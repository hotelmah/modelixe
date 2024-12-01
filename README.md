## About
ModeliXe v2 is a light-weight PHP template library that was originally used in 2001 for a guestbook. The template engine and guestbook application originated in France.
This new version 2 works in PHP 8 and can be used for experimenting, personal small projects, or further upgrading. I wanted to resurrect my old guestbook. Thus, I put some time into repairing this ModeliXe template engine.


ModeliXe v1 was the templating engine featured in a vintage web-based guestbook named [@lexGuestbook](https://www.alexguestbook.net/).
Their website is still up and running. You can download the original code from their website located at this link:
[@lexGuestbook Original Code Download](https://www.alexguestbook.net/livre-dor-gratuit-en-php/).


## Directories and Files Not Included in Packagist Package
- CSS/
- Templates/
- .gitattributes
- Quad-Template-Test-1.php
- Table-Tempalte-Test-1.php


## Test Files
- *Quad-Template-Test-1.php*
- *Table-Template-Test-1.php*
- These test files demonstrate how the library works.


## Library Features
- HTML Template Variable syntax:

```html
<title>{text id="Title"}</title>
```

- HTML Bloc Template Variable syntax:

```html
<div>
    {start id="BlocTop"}

    {end id="BlocTop"}
</div>
```

- Using the Bloc feature, you can append, delete, replace, loop, and modify blocks of HTML.
- The modify option allows you to load another template reference into the HTML document.
- The Bloc feature also allows you to loop a template reference.
- For example, you can read dynamic data from a database, and render it using this library (for experimental purposes).
- See the Tables Test 1 sample file for an illustration.


## Installation - Composer
- run this command in your project root:

`
composer require hotelmah/modelixe
`

- There is no need to manually create/update a composer.json file in your project root since this command does it automatically.
- The package is listed on Packagist, but is hosted on GitHub where the source is pulled from.


## Installation - Manual
- Copy the src directory contents to an appropriately named directory like includes/ in your LAMP web hosting provider.
- Refer to the 2x test files above.


## Notes
- There is no further documentation for this library.
- The samples are not included in the Packagist package.
- The samples serve as the tool to learn how to use the library.
- Included in the samples are how to create a form select drop-down control.
- There are additional features of the library to be discovered by browsing the code.
- For example, the template engine can also create links, images links, radio buttons, etc.
- If you like to see me upload more samples, post a discussion or issue entry. Thanks!
- What's great about a template engine is seperating server code from structure and styling languages.


## Purpose
- Revisit the past.
- Experiment with an old template engine.
- Use it as a light weight engine for testing or small purposes.
- Upgrade the project.


## Future Upgrades
- The caching feature is not working.
- The Error Manager could use improvement.
- Additional minor code improvements and refactoring.


## Feedback
- Forks and Pull Requests are welcomed.
- Suggestions and comments for improvement are requested.
- Thank you for reading!


## License
- GNU GENERAL PUBLIC LICENSE, Version 3.