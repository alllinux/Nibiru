<?php
/**
 * Created by PhpStorm.
 * User: kasdorf
 * Date: 08.03.18
 * Time: 11:33
 */
namespace Nibiru;

class Model extends Table
{
    const PHP_FILE_ENDING = '.php';

    public function __construct($argv)
    {
        if(Config::getInstance()->getConfig()[IMysql::SETTINGS_DATABASE][IMysql::PLACE_IS_ACTIVE])
        {
            parent::__construct($argv);
            $this->createOutFolder();
            $this->createClassFiles();
        }
        else
        {
            return false;
        }
    }

    private function createOutFolder()
    {
        if(!is_dir($this->getFolderOut()))
        {
            mkdir($this->getFolderOut(), 0777, true);
            chmod($this->getFolderOut(), 0777);
        }
    }

    private function createClassFiles()
    {
        if($this->getTable()!="")
        {
            $this->generateClassByTableName( $this->getTable() );
        }
        else
        {
            $tables = array_keys($this->getTables());
            foreach ($tables as $table)
            {
                $this->generateClassByTableName( $table );
            }
        }
    }

    private function generateClassByTableName( $table = false )
    {
        if($table)
        {
            $pclassname = explode('_', $table);
            $classname = "";
            for($i=0; count($pclassname)>$i; $i++)
            {
                if($i!=0)
                {
                    $classname .= ucfirst($pclassname[$i]);
                }
                else
                {
                    $classname = $pclassname[$i];
                }
            }
            if(Config::getInstance()->getConfig()[self::CONFIG_SECTION][self::DB_OVERWRITE_MODELS])
            {
                unlink($this->getFolderOut() . '/' . $classname . self::PHP_FILE_ENDING);
            }
            if(!file_exists($this->getFolderOut() . '/' . $classname . self::PHP_FILE_ENDING))
            {
                fclose( fopen( $this->getFolderOut() . '/' . $classname . self::PHP_FILE_ENDING, 'w') );
                $tablefields = $this->getTables()[$table];
                $numItems = count($tablefields);
                $i = 0;
                $fieldarray = "";
                foreach($this->getTables()[$table] as $field)
                {
                    if( $i==0 )
                    {
                        $fieldarray .= 'array( ' . "\n";
                    }

                    if( ++$i === $numItems )
                    {
                        $fieldarray .= "\t\t\t\t\t\t\t\t'" . $field . "' => '" . $field . "'"."\n\t\t\t\t\t\t)";
                    }
                    else
                    {
                        $fieldarray .= "\t\t\t\t\t\t\t\t'" . $field . "' => '" . $field . "',\n";
                    }

                }
                $template = str_replace('[FIELDARRAY]', $fieldarray, $this->getModelTemplate());
                $template = str_replace('[TABLE]', $table, $template);
                $template = str_replace('[CLASSNAME]', ucfirst($classname), $template);
                $template = str_replace('[FOLDERNAME]', ucfirst($this->getFolderNamespace()), $template);
                $template = str_replace('[DBSECTION]', $this->getConfigSection(), $template);

                if($this->getDatabaseDriver()==self::DB_DRIVER_POSTGRESS)
                {
                    if(Config::getInstance()->getConfig()[self::CONFIG_SECTION]['odbc'])
                    {
                        $template = str_replace('[ADAPTER]', self::ADAPTER_POSTGRES, $template);
                        $template = str_replace('[CONNECTOR]', self::ADAPTER_POSTGRES, $template);
                    }
                    else
                    {
                        $template = str_replace('[ADAPTER]', self::ADAPTER_POSTGRESQL, $template);
                        $template = str_replace('[CONNECTOR]', self::ADAPTER_POSTGRESQL, $template);
                    }
                }
                if($this->getDatabaseDriver()==self::DB_DRIVER_MYSQL)
                {
                    $template = str_replace('[ADAPTER]', self::ADAPTER_MYSQL, $template);
                    $template = str_replace('[CONNECTOR]', self::ADAPTER_PDO, $template);
                }

                if(Config::getInstance()->getConfig()[self::CONFIG_SECTION][self::DB_OVERWRITE_MODELS])
                {
                    file_put_contents($this->getFolderOut() . '/' . $classname . self::PHP_FILE_ENDING, $template);
                    chmod($this->getFolderOut() . '/' . $classname . self::PHP_FILE_ENDING, 0777);
                }
                else
                {
                    if(!filesize($this->getFolderOut() . '/' . $classname . self::PHP_FILE_ENDING))
                    {
                        file_put_contents($this->getFolderOut() . '/' . $classname . self::PHP_FILE_ENDING, $template);
                        chmod($this->getFolderOut() . '/' . $classname . self::PHP_FILE_ENDING, 0777);
                    }
                }
            }
        }
    }
}