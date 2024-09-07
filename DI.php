<?php
    class DI
    {
        private $container = array();

        public function configure(string $path)
        {
            $data = simplexml_load_file($path);

            foreach ($data->class as $class)
            {
                $classname = (string)$class['name'];

                foreach ($class->instance as $inst)
                {
                    $instname = (string)$inst['inst'];

                    if ($inst->arg)
                    {                    
                        $args = (array)$inst->arg;

                        $instance = function() use ($instname, $args)
                        {
                            require_once("$instname.php");

                            $rc = new ReflectionClass($instname);
                            return $rc->newInstance(...$args);
                        };
                    }
                    else
                    {
                        $instance = function() use ($instname)
                        {
                            require_once("$instname.php");

                            $rc = new ReflectionClass($instname);
                            return $rc->newInstance();
                        };
                    }

                    $this->container[$classname] = $instance;
                }
            }

            foreach($data->config->elem as $elem)
            {
                $name = (string)$elem['name'];

                $this->container[$name] = function() use ($elem)
                {
                    return (int)$elem[0];
                };
            }
        }

        public function get(string $name)
        {
            return $this->container[$name]();
        }
    }
?>