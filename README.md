# LocalFood

## Étapes d'installation

Créer un fichier `.env.local` à la racine du projet et y ajouter les variables d'environnement suivantes :

```
DATABASE_URL="mysql://root:root@127.0.0.1:3306/localfood?serverVersion=5.7.36&charset=utf8mb4"
```

Installer les dépendances du projet :

```
composer install
```

Créer la base de données :

```
php bin/console doctrine:database:create
```

Créer les tables de la base de données :

```
php bin/console doctrine:migrations:migrate
```

Charger les données de test :

```
php bin/console doctrine:fixtures:load
```

Lancer le serveur de développement :

```
symfony serve
```

### Optionnel

Utiliser Docker pour démarrer le service Mailpit :

```
docker-compose up mailer
```

La boîte de réception Mailpit est accessible à l'adresse suivante : [http://localhost:8025](http://localhost:8025)

Utiliser le composant Messenger pour envoyer des emails :

```
symfony console messenger:consume async
```

Utiliser le composant Messenger pour gérer les tâches planifiées :

```
php bin/console messenger:consume scheduler_check_user_accounts -vv
```

## Documentation pour la création de tâches planifiées

[Document Symfony Scheduler](https://symfony.com/doc/current/scheduler.html)

Créer une classe qui représentera les données du message qui déclenchera la tâche planifiée.
Dans cet exemple, la classe `CheckUserAccounts` représente le message qui déclenchera la tâche planifiée.
Cette classe ne contient aucune donnée, mais elle pourrait contenir des données nécessaires à l'exécution de la tâche planifiée.

```php
<?php
// src/Scheduler/Message/CheckUserAccounts.php

namespace App\Scheduler\Message;

class CheckUserAccounts
{

}
```

Créer une classe qui représentera la tâche planifiée.
Dans cet exemple, la classe `CheckUserAccountsHandler` représente la tâche planifiée.
Cette classe doit implémenter la méthode `__invoke` qui sera exécutée lors de la planification de la tâche.

```php
<?php
// src/Scheduler/Handler/CheckUserAccountsHandler.php

namespace App\Scheduler\Handler;

use App\Repository\UserRepository;
use App\Scheduler\Message\CheckUserAccounts;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Email;

#[AsMessageHandler]
class CheckUserAccountsHandler
{
    public function __construct(private UserRepository $userRepository, private MailerInterface $mailer)
    {
    }

    public function __invoke(CheckUserAccounts $message)
    {
        $users = $this->userRepository->findInactiveUsers();
        foreach ($users as $user) {
            // send an email to the user
            $email = (new Email())
                ->from('no-reply@localfood.com')
                ->to($user->getEmail())
                ->subject('Your account is inactive')
                ->text('Your account has been inactive for a year. Please log in to keep it active.');
            $this->mailer->send($email);
        }
    }
}
```

Créer un fichier de configuration pour définir la tâche planifiée.
Dans cet exemple, le fichier `CheckUserAccountsProvider.php` définit la tâche planifiée.
La classe doit implémenter l'interface `ScheduleProviderInterface` et la méthode `getSchedule` qui retourne un objet `Schedule` contenant la tâche planifiée.
L'attribut `AsSchedule` permet de définir le nom de la tâche planifiée qui pourra être utilisé pour la démarrer.

```php
<?php
// src/Scheduler/CheckUserAccountsProvider.php

namespace App\Scheduler;

use App\Scheduler\Message\CheckUserAccounts;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;

#[AsSchedule('check_user_accounts')]
class CheckUserAccountsProvider implements ScheduleProviderInterface
{

    private Schedule $schedule;

    public function getSchedule(): Schedule
    {
        if  (!isset($this->schedule)) {
            $schedule = new Schedule();
            $schedule->add(RecurringMessage::every('1 minute', new CheckUserAccounts()));
            $this->schedule = $schedule;
        }

        return $this->schedule;
    }
}
```

Enfin, il sera possible de tester la tâche planifiée en utilisant la commande suivante :

```
php bin/console debug:scheduler
```

