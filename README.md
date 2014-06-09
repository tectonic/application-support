# Application support

This repository is a set of classes and utilities that are designed to aid in Laravel 4 development by setting up a defacto standard or approach to certain development methods. It is an amalgamation of various community sources and inspirational projects, including Jeffrey Way's Domain driven design series, as well as the Laravel.io project. It also includes some extra features and functionality, and will continue to grow as community needs expand.

# Domain-Driven design (DDD)

There's a lot of hype and talk of late around DDD and what that means for us as developers. Instead of each of us having to rebuild the various
components (there's a few) to support this ideological approach to application development, why not have a library you can call upon whenever
you need these features?

One of the core tenets of DDD is the ability to send commands that will in turn be handled by a command handler which executes the required code for that action and then returns a result. Combine this with event sourcing and you have a hell of a powerful suite of tools for development that supports SOLID design principles.

Let's start with setting up the usual code one might expect for user registration. What we'll do is using the Application Support library, we'll setup the controller, inject the required dependencies, write our command, hook into some events and then return a response to our client.

# Use case

In this use case we're going to look at a user registration action. The user will register, or attempt to - by submitting a form that contains their requested email address, the password they would like to use, and also the password confirmation field. Let's start by looking at the method on our registration controller that will do this.

    <?php

    class RegistrationController extends \Tectonic\Application\Support\BaseController
    {
        protected $registrationService;

        public function __construct(RegistrationService $registrationService)
        {
            $this->registrationService = $registrationService;
        }

        public function postIndex()
        {
            $this->registrationService->register(Input::get());
        }
    }


Pretty straight-forward. We're defining a dependency for the registration controller which is a service which will handle the registration logic itself. In this manner, the controller simply acts as a conduit through which requests come in, get directed to the appropriate service, and deal with the response in some way. Let's look at the registration service.

    <?php

    use Tectonic\Application\Validation\ValidationCommandBus;

    class RegistrationService
    {
    	use EventGenerator;

    	protected $commandBus;

    	public function __construct(ValidationCommandBus $commandBus)
    	{
    		$this->commandBus = $commandBus;
    	}

    	/**
    	 * Registers a new user account based on the array of information provided.
    	 *
    	 * @param array $input
    	 * @return mixed
    	 */
    	public function register(array $input)
    	{
    		$command = new UserRegistersCommand($input['email'], $input['password'], $input['password_confirmation']);

    		$user = $this->commandBus->execute($command);

    		$this->raise(new UserHasRegistered($user));

    		return $user;
    	}
    }

In this service we're making good use of some base application support functionality. One if the EventGenerator, which we use after a user has registered successfully to fire off an event. We're also using the ValidationCommandBus. This class acts as a decorator to the DefaultCommandBus, essentially wrapping the execute method in some validation calls.

You'll also notice two other objects that we're using: UserRegistersCommand and UserHasRegistered. Let's cover these now.

    <?php
    class UserRegistersCommand extends \Tectonic\Application\Commanding\Command
    {
    	public $email;
    	public $password;
    	public $password_confirmation;

    	public function __construct($email, $password, $password_confirmation)
    	{
    		$this->email = $email;
    		$this->password = $password;
    		$this->password_confirmation = $password_confirmation;
    	}
    }


What happens is that we create a new class that extends the Command class, essentially creating an object that acts as a data-transfer object (DTO). The DefaultCommandBus then looks at the name of the command to discover the command handler. Every command needs a handler. With Application support, that handler needs to reside within the same directory as the command itself. So in this case, alongside UserRegistersCommand, should be UserRegistersCommandHandler. Let's see what that looks like.


    <?php
    use Tectonic\Application\Eventing\EventDispatcher;

    class UserRegistersCommandHandler implements use Tectonic\Application\Commanding\CommandHandler
    {
    	protected $dispatcher;
    	protected $userRepository;

    	public function __construct(UserRepository $userRepository, EventDispatcher $dispatcher)
    	{
    		$this->userRepository = $userRepository;
    		$this->dispatcher = $dispatcher;
    	}

    	/**
    	 * Handles the user registration command.
    	 *
    	 * @param $command
    	 */
    	public function handle($command)
    	{
    		$user = $this->userRepository->register(
    			$command->email,
    			$command->password
    		);

    		$this->dispatcher->dispatch($user->releaseEvents());

    		return $user;
    	}
    }

We won't cover repositories here as that's pretty basic stuff, but you should know that the Application support codebase includes a base-level repository that you can use in your own projects. Check Tectonic\Application\Support\BaseRepository.
    
    <?php
    class UserHasRegistered extends use \Tectonic\Application\Eventing\Event
    {
        public $user;

        public function __construct(User $user)
        {
            $this->user = $user;
        }
    }