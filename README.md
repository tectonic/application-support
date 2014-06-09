# Application support

This repository is a set of classes an utilities that are designed to aid in Laravel 4 development by setting up a defacto standard or approach to certain methods. It is an amalgamation of various community sources and inspirational projects, including Jeffrey Way's Domain driven design series, as well as the Laravel.io project.

There's a lot of hype and talk of late around DDD and what that means for us as developers. Instead of each of us having to rebuild the various
components (there's a few) to support this ideological approach to application development, why not have a library you can call upon whenever
you need these features?

# Domain-Driven design (DDD)

One of the core tenets of DDD is the ability to send commands that will in turn be handled by a command handler which executes the required code for that action and then returns a result. Combine this with event sourcing and you have a hell of a powerful suite of tools for development that supports SOLID design principles.

Let's start with setting up the usual code one might expect for user registration. What we'll do is using the Application Support library, we'll setup the controller, inject the required dependencies, write our command, hook into some events and then return a response to our client.

