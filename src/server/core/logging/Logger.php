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

class Logger
{
    const DEFAULT_CHANNEL = "default";
    /**
     * @var Zend_Log
     */
    protected $logProvider = null;
    protected $appendersCount = 0;
    protected $department = null;

    /**
     * Get message departement
     *
     * @return string
     */
    public function getDepartment()
    {
        return ($this->department);
    }

    /**
     * Sets message department
     *
     * @param string $value
     */
    public function setDepartment($value)
    {
        $this->department = $value;
    }

    /**
     * Singleton implementation
     *
     * @param string $channel . The logging channel. Leaving this parameter empty you get the "default" channel
     * @return Logger
     */
    public static function &getInstance($channel = null)
    {
        static $channels = array();
        if (is_null($channel))
            $channel = self::DEFAULT_CHANNEL;
        if (!array_key_exists($channel, $channels))
            $channels[$channel] = new Logger();
        $instance = $channels[$channel];
        return ($instance);
    }

    /**
     * Default constructor
     */
    public function __construct()
    {
        $this->logProvider = new Zend_Log();
    }

    /**
     * Adds an appender to the appenders list
     *
     * @param LoggerFileAppender $appender
     */
    public function addAppender(Zend_Log_Writer_Abstract $appender)
    {
        $this->logProvider->addWriter($appender);
    }

    /**
     * Post an info message
     *
     * @param string $message
     * @param integer $code
     */
    public function info($message, $code = null)
    {
        $this->sendMessage($message, $code, Zend_Log::INFO);
    }

    /**
     * Post a warning message
     *
     * @param string $message
     * @param integer $code
     */
    public function warn($message, $code = null)
    {
        $this->sendMessage($message, $code, Zend_Log::WARN);
    }

    /**
     * Post an error message
     *
     * @param string $message
     * @param integer $code
     */
    public function error($message, $code = null)
    {
        $this->sendMessage($message, $code, Zend_Log::ERROR);
    }

    /**
     * Post a debug message
     *
     * @param string $message
     * @param integer $code
     */
    public function debug($message, $code = null)
    {
        $this->sendMessage($message, $code, Zend_Log::DEBUG);
    }

    /**
     * Reset the list of all appenders
     */
    public function flushAppenders()
    {
        $this->logProvider = new Zend_Log();
        $this->appendersCount = 0;
    }

    public function getAppendersCount()
    {
        return ($this->appendersCount);
    }

    /**
     * Returns logger file appender
     *
     * @param integer $index
     * @return LoggerFileAppender
     */
    public function getAppender($index)
    {
        if (($index < 0) || ($index > $this->appendersCount))
            throw new OutOfRangeException("Invalid index parameter (value = $index), max allowed was: " . ($this->appendersCount - 1));
        return ($this->logProvider->getWriter($index));
    }

    /**
     * Push a message to all registered appenders
     *
     * @param string $message
     * @param integer $code
     * @param integer $level
     */
    private function sendMessage($message, $code, $level)
    {
        /**
         * Getting class info. Using debug_backtrace going 2 step behihd
         */
        $dataTrace = debug_backtrace();
        $sourcePattern = "";

        if (sizeof($dataTrace) > 2) {
            $row = $dataTrace[2];
            array_key_exists('function', $row) ? $method = $row['function'] : $method = null;
            array_key_exists('file', $row) ? $file = $row['file'] : $file = null;
            array_key_exists("class", $row) ? $class = $row["class"] : $class = null;
            if (!is_null($class) && !is_null($method)) {
                $sourcePattern = "#class#.#method#() ";
                $sourcePattern = str_replace("#class#", $class, $sourcePattern);
                $sourcePattern = str_replace("#method#", $method, $sourcePattern);
            }
            elseif (!is_null($method))
                $sourcePattern = $method . "() ";
        }
        else {
            $row = $dataTrace[1];
            $file = basename($row["file"]);
            $sourcePattern = "file: " . $file . " ";
        }
        if (!is_null($code))
            $codePattern = "[$code] ";
        else
            $codePattern = "";

        if (!is_null($this->department))
            $department = "[" . $this->department . "] ";
        else
            $department = "";

        unset($dataTrace);
        $this->logProvider->log($department . $codePattern . $sourcePattern . $message, $level);
    }
}

/**
 * Service function to simply trace a debug message
 *
 * @param string $message The message to log
 */
function trace($message)
{
    Logger::getInstance()->debug($message);
}

