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

class AmfetamineServer
{
    const CONFIG_FOLDER = "config";
    const CONFIG_FILE = "config.php";
    const TEMPLATES_SUBPATH = "webroot/assets/templates";

    /**
     * Member variable for property Config.
     *
     * @var mixed
     */
    protected $config = array();
    /**
     * Member variable for property RootPath.
     *
     * @var mixed
     */
    protected $rootPath = null;
    /**
     * True if instance initialized
     *
     * @var boolean
     */
    protected $initDone = false;
    /**
     * Logger instance
     *
     * @var Logger
     */
    protected $logger = null;
    /**
     *
     * @var AmfGateway
     */
    protected $amfGateway = null;
    /**
     * Member variable for property ClassMapperCommand.
     *
     * @var ClassMapperInterface
     */
    protected $classMapperCommand = null;
    /**
     * Member variable for property DatabaseProvider.
     *
     * @var DatabaseProviderInterface
     */
    protected $databaseProvider = null;
    /**
     * Member variable for property DebugMode.
     *
     * @var boolean
     */
    protected $debugMode = false;

    /**
     * Getter method for the member DebugMode.
     *
     * @author metagûsto
     * @return boolean The value of DebugMode.
     */
    public function isDebugMode()
    {
        return ($this->debugMode);
    }

    /**
     * Setter method for the member DebugMode.
     *
     * @author metagûsto
     * @param  boolean $value The value set to DebugMode
     * @return void
     */
    public function setDebugMode($value)
    {
        $this->debugMode = $value;
    }

    /**
     * Getter method for the member ClassMapperCommand.
     *
     * @author metagûsto
     * @return ClassMapperInterface The value of ClassMapperCommand.
     */
    public function getClassMapperCommand()
    {
        return ($this->classMapperCommand);
    }

    /**
     * Setter method for the member ClassMapperCommand.
     *
     * @author metagûsto
     * @param  ClassMapperInterface $value The value set to ClassMapperCommand
     * @return void
     */
    public function setClassMapperCommand(ClassMapperInterface $value)
    {
        $this->classMapperCommand = $value;
    }

    /**
     * Getter method for the member DatabaseProvider.
     *
     * @author metagûsto
     * @return DatabaseProviderInterface The value of DatabaseProvider.
     */
    public function getDatabaseProvider()
    {
        return ($this->databaseProvider);
    }

    /**
     * Setter method for the member DatabaseProvider.
     *
     * @author metagûsto
     * @param  DatabaseProviderInterface $value The value set to DatabaseProvider
     * @return void
     */
    public function setDatabaseProvider(DatabaseProviderInterface $value)
    {
        $this->databaseProvider = $value;
    }

    /**
     * Getter method for the member RootPath.
     *
     * @author metagûsto
     * @return string. The value of RootPath.
     */
    public function getRootPath()
    {
        if (is_null($this->rootPath))
            $this->rootPath = realpath(dirname(dirname(__FILE__) . "/../../.."));
        return ($this->rootPath);
    }

    /**
     * Returns templates path
     *
     * @return string
     */
    public function getTemplatesPath()
    {
        return (Path::combine($this->getRootPath(), self::TEMPLATES_SUBPATH));
    }

    /**
     * Getter method for the member Config.
     *
     * @author metagûsto
     * @return mixed. The value of Config.
     */
    public function getConfig()
    {
        return ($this->config);
    }

    /**
     * Setter method for the member Config.
     *
     * @author metagûsto
     * @param  mixed $value . The value set to Config
     * @return void
     */
    public function setConfig($value)
    {
        $this->config = $value;
    }

    /**
     * Singleton implementation
     * @return AmfetamineServer
     */
    public static function &getInstance()
    {
        static $instance;
        if (is_null($instance))
            $instance = new AmfetamineServer();
        return ($instance);
    }

    /**
     * Default constructor
     */
    public function __construct()
    {
        // Setting up dependencies:
        import_package("com.zend.logging");
        $this->logger = & Logger::getInstance();
    }

    /**
     * Runs AMF Endpoint Gateway
     */
    protected function actionProcessAmf()
    {
        $this->amfGateway = new AmfGateway();
        $this->initialize();
        $this->setupClassAliases();
        $this->logger->setDepartment("gateway");
        $this->logger->info("Processing Remote AMF Request for client: " . NetHelper::getClientIp());
        $config = $this->getConfig();

        // Building Up Gateway
        $this->amfGateway->setClassMappingPath($config ["amf"] ["mapping"] ['path'] ["classes"]);
        $this->amfGateway->setServiceMappingPath($config ["amf"] ["mapping"] ['path'] ["services"]);
        $this->amfGateway->setRawIncomingMessagesPath($config ["amf"] ["raw-dumping-path"] ['incoming']);
        $this->amfGateway->setRawOutcomingMessagesPath($config ["amf"] ["raw-dumping-path"] ['outcoming']);
        $this->amfGateway->setRawAmfDumpEnabled($config ["settings"] ["dump-amf-messages"]);
        $this->amfGateway->setDebugMode($config ["settings"] ["debug-mode"]);

        // Running AMF Gateway
        $this->amfGateway->run();
    }

    /**
     * Notifies a fatal error
     *
     * @param string $error The message to show
     * @param array $stacktrace
     */
    protected function notifyFatalError($error, array $stacktrace = null)
    {
        // Logging error
        try {
            $this->logger->error("Fatal error: $error");
            $this->logger->error("Stacktrace: " . var_export($stacktrace, true));
        }
        catch (Exception $ex) {
            $logerror = "Bad logger configuration: " . $ex->getMessage() . "\n" . $ex->getTraceAsString();
            $logerror .= "\nRoot cause: $error / " . var_export($stacktrace, true);
            $error = $logerror;
            $this->debugMode = true;
        }

        $view = new ShowFatalErrorView($this->getTemplatesPath());
        $view->setTitle('Fatal error');
        if ($this->isDebugMode()) {
            $view->setMessage($error);
            $view->setStacktrace($stacktrace);
        }
        else {
            $view->setMessage("Fatal error occurred. Please contact system administrator to fix this problem.");
        }
        $view->show();
        $this->terminate();
    }

    /**
     * Runs AMFetamine server
     */
    public function run()
    {
        import_package("org.amfphp.amfphp");
        try {
            // Processing requests
            $this->actionProcessAmf();
        }
        catch (MissingConfigException $ex) {
            $this->notifyFatalError("Please configure your server: " . $ex->getMessage(), $ex->getTrace());
        }
        catch (Exception $ex) {
            $this->notifyFatalError("Critical error: " . $ex->getMessage(), $ex->getTrace());
        }
        $this->terminate();
    }

    /**
     * Terminates server
     */
    protected function terminate()
    {
        $this->logger->info("/AMF Request completed ----");
        die();
    }

    /**
     * Initializes Application
     */
    protected function initialize()
    {
        if ($this->initDone)
            return;

        // loading configuration
        $this->loadConfig();
        $this->initializeLogger();
        $this->initializeDatabaseProvider();
        $this->initializeHttpSession();
        $this->initDone = true;
    }

    /**
     * setup database connection
     */
    protected function initializeDatabaseProvider()
    {
        if (!is_null($this->databaseProvider)) {
            if (!$this->databaseProvider->connect())
                $this->logger->error("Unable to connect to database");
            else
                $this->logger->info("Succesfully connected to database");
        }
    }

    /**
     * Processes $map array and creates n-aliases for each
     * couple of local/remote class inside array.
     *
     * @param array $map
     * @return void
     */
    protected function mapClassAliases(array $map)
    {
        foreach ($map as $localName => $remoteName)
            $this->amfGateway->setClassAlias($localName, $remoteName);
    }

    /**
     * Setting up local/remote class aliases
     */
    protected function setupClassAliases()
    {
        if (!is_null($this->getClassMapperCommand()))
            $this->mapClassAliases($this->getClassMapperCommand()->execute());
    }

    /**
     * Initializes Http Session
     */
    protected function initializeHttpSession()
    {

    }

    /**
     * Loads configuration
     */
    protected function loadConfig()
    {
        $configPath = Path::combine($this->getRootPath(), self::CONFIG_FOLDER);
        $configFile = Path::combine($configPath, self::CONFIG_FILE);
        $config = array();
        if (!file_exists($configFile))
            throw new MissingConfigException($configFile);

        define("__SERVER_CONFIG_FILE__", $configFile);
        require_once(__SERVER_CONFIG_FILE__);
        $transformation = new AmfetamineConfigTransformation();
        $config = $transformation->transform($config);
        $this->validateConfig($config);
        $this->config = $config;

        // Manual settings
        $mapper = $this->config ['amf'] ['mapping'] ['mapper'];
        if (!is_null($mapper))
            $this->setClassMapperCommand(new $mapper());

        $databaseProvider = $this->config ['facilities'] ['databaseProviderClass'];
        if (!is_null($databaseProvider))
            $this->setDatabaseProvider(new $databaseProvider());
    }

    /**
     * Validates configuration
     * @param array $config
     * @throws InvalidConfigException
     */
    protected function validateConfig(array $config)
    {
        $valid = true;
        $messages = "";
        if (!array_key_exists('logging', $config)) {
            $messages .= "Missing logging configuration";
            $valid = false;
        }

        // TODO: add other validation checks
        if (!$valid)
            throw new InvalidConfigException($messages);
    }

    /**
     * Initializes Logger using channel definition in configuration file
     */
    protected function initializeLogger()
    {
        $config = $this->getConfig();
        $loggingPath = $config ["logging"] ["path"];
        $logFilename = $config ["logging"] ["filename"];

        // Setting up current channel
        $loggingPath = realpath($loggingPath);
        $loggingFilename = Path::combine($loggingPath, $logFilename);
        $appender = new LoggerFileAppender($loggingFilename, "ab");
        $this->logger->addAppender($appender);
        $this->logger->setDepartment("webapp ");
        $this->logger->info(str_repeat("-", 80));
    }
}
