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

class AmfGateway
{
    /**
     * Member variable for property DebugMode.
     *
     * @var mixed
     */
    protected $debugMode = false;
    /**
     * Member variable for property ServiceMappingPath.
     *
     * @var mixed
     */
    protected $serviceMappingPath = null;
    /**
     * Member variable for property ClassMappingPath.
     *
     * @var mixed
     */
    protected $classMappingPath = null;
    /**
     * Gateway instance
     *
     * @var Gateway
     */
    protected $gateway = null;
    /**
     * True if gateway has been initialized
     *
     * @var boolean
     */
    protected $initDone = false;
    /**
     * Member variable for property RawAmfDumpEnabled.
     *
     * @var boolean
     */
    protected $rawAmfDumpEnabled = false;
    /**
     * Member variable for property RawIncomingMessagesPath.
     *
     * @var string
     */
    protected $rawIncomingMessagesPath = null;
    /**
     * Member variable for property RawOutcomingMessagesPath.
     *
     * @var string
     */
    protected $rawOutcomingMessagesPath = null;

    /**
     * Getter method for the member RawIncomingMessagesPath.
     *
     * @author metagûsto
     * @return string The value of RawIncomingMessagesPath.
     */
    public function getRawIncomingMessagesPath()
    {
        return ($this->rawIncomingMessagesPath);
    }

    /**
     * Setter method for the member RawIncomingMessagesPath.
     *
     * @author metagûsto
     * @param  string $value The value set to RawIncomingMessagesPath
     * @return void
     */
    public function setRawIncomingMessagesPath($value)
    {
        $this->rawIncomingMessagesPath = $value;
    }

    /**
     * Getter method for the member RawOutcomingMessagesPath.
     *
     * @author metagûsto
     * @return string The value of RawOutcomingMessagesPath.
     */
    public function getRawOutcomingMessagesPath()
    {
        return ($this->rawOutcomingMessagesPath);
    }

    /**
     * Setter method for the member RawOutcomingMessagesPath.
     *
     * @author metagûsto
     * @param  string $value The value set to RawOutcomingMessagesPath
     * @return void
     */
    public function setRawOutcomingMessagesPath($value)
    {
        $this->rawOutcomingMessagesPath = $value;
    }

    /**
     * Getter method for the member RawAmfDumpEnabled.
     *
     * @author metagûsto
     * @return boolean The value of RawAmfDumpEnabled.
     */
    public function isRawAmfDumpEnabled()
    {
        return ($this->rawAmfDumpEnabled);
    }

    /**
     * Setter method for the member RawAmfDumpEnabled.
     *
     * @author metagûsto
     * @param  boolean $value The value set to RawAmfDumpEnabled
     * @return void
     */
    public function setRawAmfDumpEnabled($value)
    {
        $this->rawAmfDumpEnabled = $value;
    }

    /**
     * Getter method for the member DebugMode.
     *
     * @author metagûsto
     * @return boolean. The value of DebugMode.
     */
    public function isDebugMode()
    {
        return ($this->debugMode);
    }

    /**
     * Setter method for the member DebugMode.
     *
     * @author metagûsto
     * @param  boolean $value . The value set to DebugMode
     * @return void
     */
    public function setDebugMode($value)
    {
        $this->debugMode = $value;
    }

    /**
     * Getter method for the member ServiceMappingPath.
     *
     * @author metagûsto
     * @return mixed. The value of ServiceMappingPath.
     */
    public function getServiceMappingPath()
    {
        return ($this->serviceMappingPath);
    }

    /**
     * Setter method for the member ServiceMappingPath.
     *
     * @author metagûsto
     * @param  mixed $value . The value set to ServiceMappingPath
     * @return void
     */
    public function setServiceMappingPath($value)
    {
        $this->serviceMappingPath = $value;
    }

    /**
     * Getter method for the member ClassMappingPath.
     *
     * @author metagûsto
     * @return mixed. The value of ClassMappingPath.
     */
    public function getClassMappingPath()
    {
        return ($this->classMappingPath);
    }

    /**
     * Setter method for the member ClassMappingPath.
     *
     * @author metagûsto
     * @param  mixed $value . The value set to ClassMappingPath
     * @return void
     */
    public function setClassMappingPath($value)
    {
        $this->classMappingPath = $value;
    }

    /**
     * Default constructor
     */
    public function __construct()
    {
        global $amfphp;

        /**
         * AmfPhp requires start time initialization
         */
        list ($usec, $sec) = explode(" ", microtime());
        $amfphp ['startTime'] = ((float)$usec + (float)$sec);

        /**
         * Including AMF Package
         */
        import_package("org.amfphp.amfphp");
        $this->gateway = new Gateway();
    }

    /**
     * Runs Amf Gateway
     */
    public function run()
    {
        // Initializes instance
        $this->initialize();

        // running gateway
        $this->gateway->service();
    }

    /**
     * Defines a local to remote class alias
     *
     * @param string $localClassName The local class name
     * @param string $flashClassName The remote class name
     */
    public function setClassAlias($localClassName, $flashClassName)
    {
        $GLOBALS ["amfphp"] ["incomingClassMappings"] [$flashClassName] = $localClassName;
        if ($this->debugMode)
            Logger::getInstance()->debug("Remote class '$flashClassName' will be mapped to local '$localClassName'");
    }

    /**
     * Initializes gateway
     */
    protected function initialize()
    {
        if ($this->initDone)
            return;

        // Setting up path
        $this->gateway->setClassPath($this->serviceMappingPath);
        $this->gateway->setClassMappingsPath($this->classMappingPath);
        $logger = & Logger::getInstance();
        if ($this->debugMode) {
            $logger->debug("Deployed services endpoints path is: " . $this->serviceMappingPath);
            $logger->debug(" Deployed objects endpoints path is: " . $this->classMappingPath);
        }

        // Using UTF-8 as standard encoding
        $this->gateway->setCharsetHandler("utf8_decode", "UTF-8", "UTF-8");

        // Error types that will be rooted to the NetConnection debugger
        $this->gateway->setErrorHandling(E_ALL ^ E_NOTICE);

        if (!$this->debugMode) {
            //Disable profiling, remote tracing, and service browser
            $this->gateway->disableDebug();

            // Keep the Flash/Flex IDE player from connecting to the gateway. Used for security to stop remote connections. 
            $this->gateway->disableStandalonePlayer();
        }

        // Enable gzip compression of output if zlib is available, 
        // beyond a certain byte size threshold
        $this->gateway->enableGzipCompression(25 * 1024);

        if ($this->isRawAmfDumpEnabled()) {
            $this->gateway->logIncomingMessages($this->getRawIncomingMessagesPath());
            $this->gateway->logOutgoingMessages($this->getRawOutcomingMessagesPath());
        }

        // Checking debug mode
        if ($this->debugMode)
            $logger->warn("You're running AMFetamine Server in debug mode! You should NEVER run a production server in debug mode!");

        $this->initDone = true;
    }
}

