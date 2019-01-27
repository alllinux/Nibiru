<?php

namespace Nibiru;
/**
 * Created by PhpStorm.
 * User: kasdorf
 * Date: 17.01.18
 * Time: 15:52
 */

class Table
{
    const CONFIG_SECTION            = "GENERATOR";
    const DB_CONFIG_SECTION         = "DATABASE";
    const DB_CONFIG_TEMPLATE        = "modeltemplate";
    const DB_CONFIG_BASENAME        = "basename";
    const DB_CONFIG_DRIVER          = "driver";
    const DB_CONFIG_SECTION_MODEL   = "folder-out";
    const DB_CONFIG_SECTION_DB      = "config-section";
    const DB_DRIVER_POSTGRESS       = "psql";
    const DB_DRIVER_MYSQL           = "mysql";
    const DB_OVERWRITE_MODELS       = "database.overwrite";
    const ADAPTER_POSTGRES          = "Postgres";
    const ADAPTER_POSTGRESQL        = "Postgresql";
    const ADAPTER_MYSQL             = "MySQL";

    const PARAMETERS = array(
        '--table',
        '--help',
        '--folder-out',
        '--config-section'
    );

    private $_table             = "";
    private $_database          = "";
    private $_folder_out        = "";
    private $_tables            = array();
    private $_fields            = array();
    private $_db_namespace      = "";
    private $_params            = array();
    private $_template_file     = "";
    private $_model_template    = "";
    private $_config_section    = "";
    private $_database_driver   = "";

    public function __construct( $argv )
    {
        //get parameters
        if(is_array($argv))
        {
            foreach ($argv as $entry)
            {
                $this->_setParams($entry);
            }
        }

        $this->displayHelp();
        $this->_setConfigSection();
        $this->_setDatabaseDriver();
        $this->_setDatabase();
        $this->_setDbNamespace();
        $this->_setFolderOut();
        $this->_setTable();
        $this->_setTemplateFile( Config::getInstance()->getConfig()[self::CONFIG_SECTION][self::DB_CONFIG_TEMPLATE] );
        $this->_setModelTemplate();
        $this->_setTables();
    }

    protected function displayHelp()
    {
        if(array_key_exists('help', $this->getParams()))
        {
            echo "--------------------------------------------------------------------\n";
            echo "\e[48;5;0mAutogenerator for the database model classes in order to gain access\n";
            echo "\e[48;5;0mto the database. The following parameters are required:             \n";
            echo "\e[16;5;0m--------------------------------------------------------------------\n";
            echo "\n";
            echo "--table=TABLENAME\n";
            echo "( will generate only that table and overwrite the Model file )\n";
            echo "\n";
            echo "--help\n";
            echo "( will display this help, and not execute any further )\n";
            echo "\n";
            echo "--folder-out=PATH-TO-MODEL-FOLDER\n";
            echo "( will output the files into that folder )\n";
            echo "\n";
            echo "--config-section=CONFIGSECTION\n";
            echo "( is attached to the settings.env.ini file and\n";
            echo "reads that configuration to connect to the database )\n\n";
            echo "--------------------------------------------------------------------\n";
            echo "\e[48;5;0m                                                                    \n";
            echo "\e[16;5;0m--------------------------------------------------------------------\n";
            die();
        }
    }

    /**
     * @return string
     */
    protected function getDatabaseDriver(): string
    {
        return $this->_database_driver;
    }

    /**
     * @param string $database_driver
     */
    private function _setDatabaseDriver(): void
    {
        $this->_database_driver = Config::getInstance()->getConfig()[$this->getConfigSection()][self::DB_CONFIG_DRIVER];
    }

    /**
     * @return string
     */
    protected function getConfigSection()
    {
        return $this->_config_section;
    }

    /**
     * @param string $config_section
     */
    private function _setConfigSection( )
    {
        if(array_key_exists('config-section', $this->getParams()))
        {
            $this->_config_section = $this->getParams()['config-section'];
        }
        else
        {
            if(Config::getInstance()->getConfig()[self::CONFIG_SECTION][self::DB_CONFIG_SECTION_DB])
            {
                $this->_config_section = Config::getInstance()->getConfig()[self::CONFIG_SECTION][self::DB_CONFIG_SECTION_DB];
            }
            else
            {
                $this->_config_section = self::DB_CONFIG_SECTION;
            }
        }
    }

    /**
     * @return string
     */
    protected function getDatabase()
    {
        return $this->_database;
    }

    /**
     * @param string $database
     */
    private function _setDatabase( )
    {
        $this->_database = Config::getInstance()->getConfig()[$this->getConfigSection()][self::DB_CONFIG_BASENAME];
    }

    /**
     * @return string
     */
    protected function getFolderOut()
    {
        return $this->_folder_out;
    }

    /**
     * @param string $folder_out
     */
    private function _setFolderOut( )
    {
        if(array_key_exists(self::DB_CONFIG_SECTION, $this->getParams()))
        {
            $this->_folder_out = $this->getParams()[self::DB_CONFIG_SECTION_MODEL] . $this->getDatabase();
        }
        else
        {
            $this->_folder_out = __DIR__ . Config::getInstance()->getConfig()[self::CONFIG_SECTION][self::DB_CONFIG_SECTION_MODEL] . $this->getDatabase();
        }
    }

    /**
     * @return array
     */
    protected function getTables()
    {
        return $this->_tables;
    }

    /**
     * @param array $tables
     */
    private function _setTables( )
    {
        if($this->getDatabaseDriver()==self::DB_DRIVER_POSTGRESS)
        {
            if(Config::getInstance()->getConfig()[self::CONFIG_SECTION]['odbc'])
            {
                Postgres::settingsSection( $this->getConfigSection() );
                $result = Postgres::query(
                    'SELECT table_name
                      FROM information_schema.tables
                     WHERE table_schema=\'public\'
                       AND table_type=\'BASE TABLE\';'
                );
                foreach ($result as $entry)
                {
                    $this->_setFields($entry["table_name"]);
                    $this->_tables[$entry["table_name"]] = $this->getFields();
                }
            }
            else
            {
                Postgresql::settingsSection( $this->getConfigSection() );
                $result = Postgresql::query(
                    'SELECT table_name
                      FROM information_schema.tables
                     WHERE table_schema=\'public\'
                       AND table_type=\'BASE TABLE\';'
                );
                foreach ($result as $entry)
                {
                    $this->_setFields($entry["table_name"]);
                    $this->_tables[$entry["table_name"]] = $this->getFields();
                }
            }

        }
        if($this->getDatabaseDriver()==self::DB_DRIVER_MYSQL)
        {
            //TODO: Implement the Table array for MySQL
        }
    }

    /**
     * @return string
     */
    protected function getDbNamespace()
    {
        return $this->_db_namespace;
    }

    /**
     * @param string $db_namespace
     */
    private function _setDbNamespace( )
    {
        $this->_db_namespace = ucfirst($this->getDatabase());
    }

    /**
     * @return string
     */
    protected function getModelTemplate()
    {
        return $this->_model_template;
    }

    /**
     * @param string $model_template
     */
    private function _setModelTemplate( )
    {
        try
        {
            if(file_exists($this->getTemplateFile()))
            {
                $this->_model_template = file_get_contents($this->getTemplateFile());
            }
            else
            {
                throw new \Exception('ERROR: no Template file found, please provide one like in the example!');
            }
        } catch (\Exception $e)
        {
            echo "\n" . $e->getMessage() . "\n";

        }
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->_table;
    }

    /**
     * @param string $table
     */
    private function _setTable( )
    {
        if(array_key_exists('table', $this->getParams()))
        {
            $this->_table = $this->getParams()['table'];
        }
    }

    /**
     * @return array
     */
    protected function getFields()
    {
        return $this->_fields;
    }

    /**
     * @param array $fields
     */
    private function _setFields( $table )
    {
        $this->_fields = array();
        if($this->getDatabaseDriver()==self::DB_DRIVER_POSTGRESS)
        {
            if(Config::getInstance()->getConfig()[self::CONFIG_SECTION]['odbc'])
            {
                Postgres::settingsSection( $this->getConfigSection() );
                $result = Postgres::query(
                    'SELECT *
                                            FROM information_schema.columns
                                            WHERE table_schema = \'public\'
                                              AND table_name   = \'' . $table . '\''
                );
                foreach( $result as $field )
                {
                    $this->_fields[] = $field['column_name'];
                }
            }
            else
            {
                Postgresql::settingsSection( $this->getConfigSection() );
                $result = Postgresql::query(
                    'SELECT *
                                            FROM information_schema.columns
                                            WHERE table_schema = \'public\'
                                              AND table_name   = \'' . $table . '\''
                );
                foreach( $result as $field )
                {
                    $this->_fields[] = $field['column_name'];
                }
            }
        }
        if($this->getDatabaseDriver()==self::DB_DRIVER_MYSQL)
        {
            //TODO: Implement the Table array for MySQL
        }

    }

    /**
     * @return array
     */
    protected function getParams()
    {
        return $this->_params;
    }

    /**
     * @param array $params
     */
    private function _setParams( $param )
    {
        $keyvalue = explode('--', $param);
        if(array_key_exists(1, $keyvalue))
        {
            $keyvalue = explode("=", $keyvalue[1]);
            if(array_key_exists(1, $keyvalue))
            {
                $this->_params[$keyvalue[0]] = $keyvalue[1];
            }
            else
            {
                $this->_params[$keyvalue[0]] = false;
            }
        }
    }

    /**
     * @return string
     */
    protected function getTemplateFile()
    {
        return $this->_template_file;
    }

    /**
     * @param string $template_file
     */
    private function _setTemplateFile( $template_file )
    {
        if(file_exists(__DIR__ . "/" . $template_file))
        {
            $this->_template_file = __DIR__ . "/" . $template_file;
        }
    }

}