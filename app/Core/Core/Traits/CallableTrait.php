<?php

namespace App\Core\Core\Traits;

use App\Core\Core\Exceptions\ClassDoesNotExistException;
use App\Core\Core\Exceptions\MissingContainerException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

/**
 * Class CallableTrait.
 *
 */
trait CallableTrait
{

    /**
     * This function will be called from anywhere (controllers, Actions,..) by the Apiato facade.
     * The $class input will usually be an Action or Task.
     *
     * @param       $class
     * @param array $runMethodArguments
     * @param array $extraMethodsToCall
     *
     * @return  mixed
     * @throws \ReflectionException
     */
    public function call($class, $runMethodArguments = [], $extraMethodsToCall = [])
    {
        $class = $this->resolveClass($class);

        $this->setUIIfExist($class);

        $this->callExtraMethods($class, $extraMethodsToCall);

        // detects Requests arguments "usually sent by controllers", and cvoert them to Transporters.
        $runMethodArguments = $this->convertRequestsToTransporters($class, $runMethodArguments);

        return $class->run(...$runMethodArguments);
    }

    /**
     * This function calls another class but wraps it in a DB-Transaction. This might be useful for CREATE / UPDATE / DELETE
     * operations in order to prevent the database from corrupt data. Internally, the regular call() method is used!
     *
     * @param       $class
     * @param array $runMethodArguments
     * @param array $extraMethodsToCall
     *
     * @return mixed
     */
    public function transactionalCall($class, $runMethodArguments = [], $extraMethodsToCall = [])
    {
        return DB::transaction(function() use ($class, $runMethodArguments, $extraMethodsToCall) {
            return $this->call($class, $runMethodArguments, $extraMethodsToCall);
        });
    }

    /**
     * Get instance from a class string
     *
     * @param $class
     *
     * @return  mixed
     */
    private function resolveClass($class)
    {
        // in case passing apiato style names such as containerName@classType
        if ($this->needsParsing($class)) {

            $parsedClass = $this->parseClassName($class);

            $containerName = $this->capitalizeFirstLetter($parsedClass[0]);
            $className = $parsedClass[1];

            $this->verifyContainerExist($containerName);

            $class = $classFullName = $this->buildClassFullName($containerName, $className);

            $this->verifyClassExist($classFullName);
        } else {
            throw new MissingContainerException('Something CallableTrait in core');
        }

        return App::make($class);
    }

    /**
     * Build namespace for a class in Container.
     *
     * @param $containerName
     * @param $className
     *
     * @return  string
     */
    public function buildClassFullName($containerName, $className)
    {
        return 'App\Containers\\' . $containerName . '\\' . $this->getClassType($className) . 's\\' . $className;
    }

    /**
     * Get the last part of a camel case string.
     * Example input = helloDearWorld | returns = World
     *
     * @param $className
     *
     * @return  mixed
     */
    public function getClassType($className)
    {
        $array = preg_split('/(?=[A-Z])/', $className);

        return end($array);
    }

    /**
     * @param $containerName
     *
     * @throws MissingContainerException
     */
    public function verifyContainerExist($containerName)
    {
        if (!is_dir(app_path('Containers/' . $containerName))) {
            throw new MissingContainerException("Container ($containerName) is not installed.");
        }
    }

    /**
     * @param $className
     *
     * @throws ClassDoesNotExistException
     */
    public function verifyClassExist($className)
    {
        if (!class_exists($className)) {
            throw new ClassDoesNotExistException("Class ($className) is not installed.");
        }
    }

    /**
     * Split containerName@someClass into container name and class name
     *
     * @param        $class
     * @param string $delimiter
     *
     * @return  array
     */
    private function parseClassName($class, $delimiter = '@')
    {
        return explode($delimiter, $class);
    }

    /**
     * If it's apiato Style caller like this: containerName@someClass
     *
     * @param        $class
     * @param string $separator
     *
     * @return  int
     */
    private function needsParsing($class, $separator = '@')
    {
        return preg_match('/' . $separator . '/', $class);
    }

    /**
     * @param $string
     *
     * @return  string
     */
    private function capitalizeFirstLetter($string)
    {
        return ucfirst($string);
    }

    /**
     *
     * $this->ui is coming, should be attached on the parent controller, from where the actions was called.
     * It can be WebController and ApiController. Each of them has ui, to inform the action
     * if it needs to handle the request differently.
     *
     * @param $class
     */
    private function setUIIfExist($class)
    {
        if (method_exists($class, 'setUI') && property_exists($this, 'ui')) {
            $class->setUI($this->ui);
        }
    }

    /**
     * @param $class
     * @param $extraMethodsToCall
     */
    private function callExtraMethods($class, $extraMethodsToCall)
    {
        // allows calling other methods in the class before calling the main `run` function.
        foreach ($extraMethodsToCall as $methodInfo) {
            // if is array means it method has arguments
            if (is_array($methodInfo)) {
                $this->callWithArguments($class, $methodInfo);
            } else {
                // if is string means it's just the method name without arguments
                $this->callWithoutArguments($class, $methodInfo);
            }
        }
    }

    /**
     * @param $class
     * @param $methodInfo
     */
    private function callWithArguments($class, $methodInfo)
    {
        $method = key($methodInfo);
        $arguments = $methodInfo[$method];
        if (method_exists($class, $method)) {
            $class->$method(...$arguments);
        }
    }

    /**
     * @param $class
     * @param $methodInfo
     */
    private function callWithoutArguments($class, $methodInfo)
    {
        if (method_exists($class, $methodInfo)) {
            $class->$methodInfo();
        }
    }

    /**
     * For backward compatibility purposes only. Could be a temporal function.
     * In case a user passed a Request object to an Action that accepts a Transporter, this function
     * converts that Request to Transporter object.
     *
     * @param       $class
     * @param array $runMethodArguments
     *
     * @return  array
     * @throws \ReflectionException
     */
    private function convertRequestsToTransporters($class, array $runMethodArguments = [])
    {
        $requestPositions = [];

        // we first check, if one of the params is a REQUEST type
        foreach ($runMethodArguments as $argumentPosition => $argumentValue) {
            if ($argumentValue instanceof Request) {
                $requestPositions[] = $argumentPosition;
            }
        }

        // now check, if we have found any REQUEST params
        if (empty($requestPositions)) {
            // We have not found any REQUEST params, so we don't need to transform anything.
            // Just return the runArguments and we are ready...
            return $runMethodArguments;
        }

        // ok.. now we need to get the method signature from the run() method to be called on the $class
        // and check, if on the positions we found REQUESTs are TRANSPORTERs defined!
        // this is a bit more tricky than the stuff above - but we will manage this

        // get a reflector for the run() method
        $reflector = new \ReflectionMethod($class, 'run');
        $calleeParameters = $reflector->getParameters();

        // now specifically check only the positions we have found a REQUEST in the call() method
        foreach ($requestPositions as $requestPosition) {
            $parameter = $calleeParameters[$requestPosition];
            $parameterClass = $parameter->getClass();

            // check if the parameter has a class and this class actually does exist!
            if (!(($parameterClass != null) && (class_exists($parameterClass->name)))) {
                // no, some tests failed - we cannot convert - skip this entry
                continue;
            }

            // so everything is ok
        }

        return $runMethodArguments;
    }

}
