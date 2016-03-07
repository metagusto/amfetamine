<?php
/**
 * Metagûsto AMFetamine
 * Copyright (C) 2008 Metagûsto
 * Website: https://github.com/metagusto/amfetamine
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
//TODO: delete error_reporting(0); 
//error_reporting(0); 
set_error_handler("exception_error_handler");
// Registering amfetamine autoload function
spl_autoload_register("amfetamine_autoload");
$currentPath = dirname(__FILE__);

/**
 * Autoload function for the AMFetamine
 *
 * @param string $classname
 */
function amfetamine_autoload($classname)
{
    static $items;
    static $packageRoot;
    if (is_null($items)) {
        $items = array
        (
            // External Package: Zend Logger
            "package:com.zend.logging" => "libs/zend/zend-package.php",

            // External Package: AmfPhp Library
            "package:org.amfphp.amfphp" => "libs/amfphp/amfphp-main.php",

            // Logging
            "Logger" => "core/logging/Logger.php",
            "LoggerFileAppender" => "core/logging/LoggerFileAppender.php",
            "NullAppender" => "core/logging/NullAppender.php",

            // Utils
            "Path" => "core/utils/Path.php",

            // Exception
            "MissingConfigException" => "core/exceptions/MissingConfigException.php",
            "InvalidConfigException" => "core/exceptions/InvalidConfigException.php",
            "FileNotFoundException" => "core/exceptions/FileNotFoundException.php",

            // Datetime
            "Date" => "core/datetime/Date.php",

            // Views
            "ShowFatalErrorView" => "core/views/ShowFatalErrorView.php",
            "AmfetamineBasicViewInterface" => "core/views/AmfetamineBasicViewInterface.php",
            "AbstractAmfetamineView" => "core/views/AbstractAmfetamineView.php",

            // Flex AMF tools
            "AmfGateway" => "core/amf/AmfGateway.php",
            "AmfMapHelper" => "core/amf/AmfMapHelper.php",

            // Amfetamine server
            "AmfetamineServer" => "core/server/AmfetamineServer.php",

            // Config management
            "AmfetamineConfigTransformation" => "core/config/AmfetamineConfigTransformation.php",
            "ConfigLoaderTransformerInterface" => "core/config/ConfigLoaderTransformerInterface.php",

            // Net helper tools
            "NetHelper" => "core/net/NetHelper.php",

            // Database connection provider
            "DatabaseProviderInterface" => "core/data/DatabaseProviderInterface.php",

            // Class mapping
            "ClassMapperInterface" => "core/mapping/ClassMapperInterface.php",
        );
    }
    if (is_null($packageRoot)) {
        $packageRoot = dirname(__FILE__);
    }
    if (array_key_exists($classname, $items)) {
        require_once $packageRoot . "/" . $items[$classname];
    }
}

/**
 * Includes a package using his name
 *
 * @param string $name The package name (i.e.: com.metagusto.package)
 */
function import_package($name)
{
    amfetamine_autoload("package:$name");
}

/**
 * Throws a new Exception based on PHP error
 *
 * @param integer $errno
 * @param string $errstr
 * @param string $errfile
 * @param integer $errline
 */
function exception_error_handler($errno, $errstr, $errfile, $errline)
{
    switch ($errno) {
        case E_ERROR:
        case E_CORE_ERROR:
        case E_COMPILE_ERROR:
        case E_USER_ERROR:
            Logger::getInstance()->warn("Internal Problem catched: $errstr, code: $errno, file: $errfile, line: $errline");
            throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
            break;

        default:
            //print "Internal Problem catched: $errstr, code: $errno, file: $errfile, line: $errline\n";
            Logger::getInstance()->warn("Internal Problem catched: $errstr, code: $errno, file: $errfile, line: $errline");
    }
}

