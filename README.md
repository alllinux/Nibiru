# Nibiru 
### Rapid Prototyping PHP Framework
Version 0.3.5 beta
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
<li>soap interface to a given SOAP server</li>
<li>Dwoo tempalte eninge tests</li>
<li>Twig tempalte eninge tests</li>
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
<li>soap interface to a given SOAP server</li>
<li>Dwoo tempalte eninge tests</li>
<li>Twig tempalte eninge tests</li>
</ul>
<h1>Previous version</h1>
<h1>Version 0.3 beta 04.02.2018</h1>
<ul>
<li>Improved: The Router now accepts actions, either trough the _action as parameter, or on the URL pattern after the controller name Example: http://youdomain/[controllername]/[actionname]/</li>
<li>It is now possible to load as many navigations on the page as wanted by passing the name to the <br>JsonNavigation::getInstance()->loadJsonNavigationArray('[NAME]'); <br>call in the navigationAction of the Controller</li>
<li>Building forms by simple adding the namespace<br> use Nibiru\Factory\Form; <br>and calling Example:<br> Form::addInputTypeText( array( 'name' => 'lastname', 'value' => 'placeholder' ) );<br> To finalize the form the last call should be something like this:<br>Form::addForm( array('name' => 'testform', 'method' => 'post', 'action' => '/' . Router::getInstance()->currentPage(), 'target' => '_self') );</li>
<li>The Database design has fully been refactored, now it contains an autoloading mechanism which can be triggert by createing a database folder in the application folder, a Example file is in the folder applicatoin/database</li>
<li>The Database access can now be implemented anywhere in your application by adding the namespace to your database accessing Logic:<br>use Nibiru\Factory\Db;</li>
</ul>
</div>

<h1>Update</h1>
<p>Version 0.3.5 beta 14.03.2018</p>
<ul>
<li>Bugfix on the Router, now the currentPage will be returned correctly.</li>
<li>Update for the database adapter, a detailed instruction on how to use it will be within the soon comming documentation</li>
<li>Improvement of the form elements, those now are able to also swap div layers around a field, as well as correct labeling</li>
<li>Added missing form elements, migration to a Form factory, in order to easy configure and install a form anywhere you like</li>
<li>Minor bugfixing</li>
</ul>
<div style="word-spacing: 2px; letter-spacing: 0.1px; font-size: 15px; margin-bottom: 15px;">The start is done, have success with PHP prototyping, and always remember to have fun!</div>

Author: Stephan Kasdorf<br><br>