
# nibiru framework :rocket:

Welcome to the **nibiru framework**, a powerful MMVC (Modular Model-View-Controller) PHP Framework designed specifically for rapid prototyping. Whether you're building a quick prototype or a large-scale application, **nibiru framework** provides the tools and structure you need to get up and running in no time.

## What is MMVC PHP Framework for rapid prototyping?

MMVC in the **nibiru framework** stands for Modular Model-View-Controller. Modules, have the `observer` pattern, and are comprehensive entities that encompass not just the MVC components but also traits, interfaces, plugins, and settings. These modules are designed for loose coupling, promoting modularity and ease of integration. Each module can be loaded through its namespace, offering a flexible way to add and manage functionalities in your application. The built-in observer ensures seamless communication between these modules.

## nibiru Binary Command-Line Tool

```plaintext
  _   _ _ _     _              ______                                           _    
 | \ | (_) |   (_)            |  ____|                                         | |   
 |  \| |_| |__  _ _ __ _   _  | |__ _ __ __ _ _ __ ___   _____      _____  _ __| | __
 | . ` | | '_ \| | '__| | | | |  __| '__/ _` | '_ ` _ \ / _ \ \ /\ / / _ \| '__| |/ /
 | |\  | | |_) | | |  | |_| | | |  | | | (_| | | | | | |  __/\ V  V / (_) | |  |   < 
 |_| \_|_|_.__/|_|_|   \__,_| |_|  |_|  \__,_|_| |_| |_|\___| \_/\_/ \___/|_|  |_|\_
----------------------------------------------------------------------------------------------

Usage: ./nibiru [-m <module_name>] [-c <controller_name>] [-h]

  -m {name}: create a new module with the given name. Add -g switch if a Graylog Server present.
  -c {name}: create a new controller with the given name.
  -p {name} -m {name}: create a new plugin with the given name in the given name for the module.
                       add -g switch if a Graylog Server present.
  -cache-clear: will clear the cache of the applications template_c folder.
  -s: check framework folders and permissions, and set them if they are not present.
  -mi {local|staging|production}: run migration files from application/settings/config/database/.
  -mi-reset {local|staging|production}: will reset the migrations table, use only if you know what
                                        you are doing.
  -mi-reset-file {filename} {local|staging|production}: will reset the migration entry for a filename
                                                        e.g. mytable.sql, use only if you know what
                                                        you are doing.
  -ws {URL} -wp {PORT}: connect to a WebSocket at the given URL and port.
  -h: display this help message.
  -new-cms-page {name} (only available with the CMS module): will create a new page with connection
                                                             to an existing template.
  -delete-cms-page {name} (only available with the CMS module): will delete a CMS page with the given name.
  -version or -v: display the version of the nibiru binary, and the current framework version.

```

For a more detailed explanation and additional functionalities, please refer to the [official documentation](https://nibiru-framework.com).

## Database Migrations

In the **nibiru framework**, database migrations play a crucial role in managing and versioning your database schema. Migrations allow developers to define sets of changes that modify the database schema, making it easier to track, roll back, or apply updates as needed.

With the `nibiru` binary tool, managing these migrations becomes even more effortless:

- `./nibiru -mi {environment}`: This command allows you to run migration files from the `application/settings/config/database/` directory for a specific environment (`local`, `staging`, or `production`).
- `./nibiru -mi-reset {environment}`: Use this command with caution. It resets the migrations table, effectively allowing you to start fresh with your migrations.
- `./nibiru -mi-reset-file {filename} {environment}`: If you need to reset a specific migration entry, this command lets you target a particular filename, such as `mytable.sql`, for a given environment.

It's essential to use migrations to ensure that your database schema remains consistent across different environments and stages of your application's lifecycle.

## Generating Controllers

Using the `nibiru` binary tool, developers can effortlessly generate controllers for their applications:

- `./nibiru -c {controller_name}`: This command will create a new controller with the specified name.

Upon generation, the controller will be located in:

```
/application/controllers/{controller_name}.php
```

Additionally, a corresponding view file will be generated and placed in:

```
/application/views/{controller_name}/
```

This structure ensures that the logic in the controller and its associated views are neatly organized and easy to manage.

## Generating Modules

The `nibiru` binary tool also facilitates the generation of modules:

- `./nibiru -m {module_name}`: This command will create a new module with the given name.

The generated module will have its own directory structure, encompassing traits, interfaces, plugins, settings, and a main PHP file. The structure will resemble:

```
/modules/{module_name}/
    ├── {module_name}.php
    ├── interfaces/
    ├── plugins/
    ├── settings/
    └── traits/
```

This modular approach allows for clear separation of concerns and promotes scalability and maintainability of the application.

## Credits

Created by Stephan Kasdorf, 2023

---

Happy Coding! :computer:
