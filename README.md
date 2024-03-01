
## Installation

By default, Composer pulls in packages from Packagist so you’ll have to make a slight adjustment to your project's composer.json file. Open the file and update include the following array somewhere in the object:

```
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/mohdradzee/waident"
    }
]
```

Now composer will also look into this repository for any installable package. Execute the following command to install the package:

```
composer require mohdradzee/waident
```

Output should be like
```
composer require mohdradzee/waident:1.0.0
./composer.json has been updated
Running composer update mohdradzee/waident
Loading composer repositories with package information
Updating dependencies                                 
Lock file operations: 1 install, 0 updates, 0 removals
  - Locking mohdradzee/waident (1.0.0)
Writing lock file
Installing dependencies from lock file (including require-dev)
Package operations: 1 install, 0 updates, 0 removals
  - Downloading mohdradzee/waident (1.0.0)
  - Installing mohdradzee/waident (1.0.0): Extracting archive
Generating optimized autoload files
...so on
```
After the package has been installed successfully. Now, open the config/app.php file and scroll down to the providers array. In that array, there should be a section for the package service providers. Add the following line of code in that section:
```
...
/*
 * Package Service Providers...
 */
Mohdradzee\Waident\Providers\WaidentServiceProvider::class,
...

```

Finally go to {yourAppUrl}/demo-initiateauth
