# Morloax Framework

## Description
Morloax Framework is a simple MVC framework for PHP, designed to streamline the development of web applications.

## Getting Started

1. **Make an Empty Project**

   Create an empty project and add a `composer.json` file to it. Add the following code to your `composer.json` file:

    ```json
    {
      "require": {
        "royvermeulen/morloax": "^0.5.2"
      }
    }
    ```

   Run the following command in your terminal to install Morlaux Framework:

    ```bash
    composer install
    ```

2. **Initialize Morlaux Framework**

   After installing Morlaux Framework, run the following command in your terminal:

    ```bash
    php vendor/bin/morloax init
    ```

3. **Generate Settings**

   Generate the framework settings by running the following command:

    ```bash
    php vendor/bin/morloax generate:settings
    ```

4. **Update composer.json**
    
    Your composer.json should look like this:
   ```json
   {
      "autoload": {
         "psr-4": {
            "App\\": "app/",
            "Middleware\\": "middleware/"
            }
        },
       "require": {
       "royvermeulen/morloax": "^0.5.2"
       }
   }
    ```
   Now run this command:
   ```bash 
   composer dump-autolaod
    ```

Now you're done! Your Morloax Framework is set up and ready for development.
