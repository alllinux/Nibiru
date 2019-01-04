# Nibiru 
### Rapid Prototyping PHP Framework
Version 0.6.1 beta
## Introduction

<div style="word-spacing: 2px; letter-spacing: 0.1px; font-size: 12px; margin-bottom: 15px;">Nibiru is a rapid prototyping framework written in PHP and based on the MVC design pattern. Now one may say that writing <br>
another framework is not cool because there are so many, such as Symphony, ZendFramework ( where as I have prefered the<br>
first version of that framework ), Laravel, etc.. But let's be honest they are complete overkill for smaller projects and<br>
are not fit to quick start your "own" development.</div>

<div style="word-spacing: 2px; letter-spacing: 0.1px; font-size: 12px; margin-bottom: 15px;">That is why I have started my own little framework and am happy to provide the first version of Nibiru, in the version 0.1,<br>
there is still a lot of work to be done in refactoring the core features for the View, Controller and the main Template<br>
Engine Implementation.</div>

<div style="word-spacing: 2px; letter-spacing: 0.1px; font-size: 12px; margin-bottom: 15px;">
<h1>Currently supported features</h1><br>
<ul>
<li>Controller, Model, View ( already tested )</li>
<li>Smarty template engine ( already tested )</li>
<li>Dwoo template engine ( untested )</li>
<li>Twig template engine ( untested )</li>
<li>PDO adapter to the MySQL database</li>
<ol>
<li>read datasets from a complete table</li>
<li>read datasets by selection from a table</li>
<li>write datasets by array into a table</li>
</ol>
<li>Bootstrap template of a dashboard</li>
<li>Example page, on how to setup a View and Controller</li>
<li>Example page, on how to setup a navigation with a json file</li>
<li>Debugbar access through the configuration, sould be set to true in order to use it</li>
</ul>
<h1>In progress for the next version</h1>
<ul>
<li>framework documentation</li>
<li>class documentation</li>
<li>soap interface to a given SOAP server (canceled, not needed to old)</li>
<li>bitcoin api, and payment gateway</li>
<li>Dwoo tempalte engine tests</li>
<li>Twig tempalte engine tests</li>
<li>Database access functionallity for the db.php Factory</li>
</ul>

<p>Version 0.2 beta 19.07.2017</p>
<ul>
    <li>Dispatcher update now supports actions within Controllers</li>
    <li>Main Framework call moved to the framework file</li>
    <li>Added support for ODBC in a basic Postgress class</li>
    <li>Updated the router and added a static printstufftoscreen call</li>
</ul>
<p>Still in progress for the next version</p>
<ul>
<li>framework documentation</li>
<li>class documentation</li>
<li>soap interface to a given SOAP server (canceled, not needed to old)</li>
<li>bitcoin api, and payment gateway</li>
<li>Dwoo tempalte engine tests</li>
<li>Twig tempalte engine tests</li>
</ul>

<p>Version 0.3 beta 04.02.2018</p>
<ul>
<li>Improved: The Router now accepts actions, either trough the _action as parameter, or on the URL pattern after the controller name Example: http://youdomain/[controllername]/[actionname]/</li>
<li>It is now possible to load as many navigations on the page as wanted by passing the name to the <br>JsonNavigation::getInstance()->loadJsonNavigationArray('[NAME]'); <br>call in the navigationAction of the Controller</li>
<li>Building forms by simple adding the namespace<br> use Nibiru\Factory\Form; <br>and calling Example:<br> Form::addInputTypeText( array( 'name' => 'lastname', 'value' => 'placeholder' ) );<br> To finalize the form the last call should be something like this:<br>Form::addForm( array('name' => 'testform', 'method' => 'post', 'action' => '/' . Router::getInstance()->currentPage(), 'target' => '_self') );</li>
<li>The Database design has fully been refactored, now it contains an autoloading mechanism which can be triggert by createing a database folder in the application folder, a Example file is in the folder applicatoin/database</li>
<li>The Database access can now be implemented anywhere in your application by adding the namespace to your database accessing Logic:<br>use Nibiru\Factory\Db;</li>
</ul>
</div>
<p>Version 0.3.5 beta 14.03.2018</p>
<ul>
<li>Bugfix on the Router, now the currentPage will be returned correctly.</li>
<li>Update for the database adapter, a detailed instruction on how to use it will be within the soon comming documentation</li>
<li>Improvement of the form elements, those now are able to also swap div layers around a field, as well as correct labeling</li>
<li>Added missing form elements, migration to a Form factory, in order to easy configure and install a form anywhere you like</li>
<li>Minor bugfixing</li>
</ul>

<h1>Previous version</h1>
<p>Version 0.4.0 beta 28.08.2018</p>
<ul>
<li>Minor update concerning the autoloading class in the core, now it is also possible to give a loading order through the configuration</li>
<li>Minor update concerning the form factory classes in the core, now some javascript events are implemented as well, another update concerning functinoallity will follow soon.</li>
<li>Update on the example configuration file, implementing the autoloading order of interfaces, moduels and traits.</li>
<li>Update for multidatabase support, see the documentation on http://www.nibiru-framework.com</li>
</ul>

<h1>Update</h1>
<p>Version 0.6.0 beta 05.12.2018</p>
<ul>
<li>Added a Pagination to the core it now can be used like in the template file Example, the class just needs to be extended by the module that should have a pageination (e.g. a Blog Module)</li>
<li>Some extensions for the Routing option, in order to parmeterize the url.</li>
<li>Name fixing.</li>
<li>Added an additional attribute for the navigation, so the navigation position can be set to footer.</li>
<li>A soap extension will not be part of the system anymore, since that is just a bad habit, so this will be replaced with a REST api.</li>
</ul>

<h1>Bugfixing</h1>
<p>Version 0.6.1 beta 04.01.2019</p>
<ul>
<li>Bugfix for the pagination in the core files, used not to work on more then three pages, is now fixed.</li>
</ul>

<div style="word-spacing: 2px; letter-spacing: 0.1px; font-size: 15px; margin-bottom: 15px;">The start is done, have success with PHP prototyping, and always remember to have fun!</div>
Author: Stephan Kasdorf<br><br>