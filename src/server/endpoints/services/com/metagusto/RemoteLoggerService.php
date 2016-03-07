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

class RemoteLoggerService
{
    public $methodTable = array();
    /**
     * Logger instance
     *
     * @var Logger
     */
    protected $logger = null;

    /**
     * Service Constructor
     */
    public function __construct()
    {
        $serviceRemark = "metagûsto Flex Remoting Logger Service";
        $this->methodTable = MethodTable::create(get_class($this), dirname(__FILE__) . "/", $serviceRemark);
        $this->logger = & Logger::getInstance();
        $this->logger = clone ($this->logger);
        $this->logger->setDepartment("flex   ");
    }

    /**
     * Post a message of level INFO
     *
     * @param string $message . The log message. This parameter is required.
     */
    public function info($message)
    {
        $this->logger->info($message);
    }

    /**
     * Post a message of level WARN
     *
     * @param string $message . The log message. This parameter is required.
     */
    public function warn($message)
    {
        $this->logger->warn($message);
    }

    /**
     * Post a message of level ERROR
     *
     * @param string $message . The log message. This parameter is required.
     */
    public function error($message)
    {
        $this->logger->error($message);
    }

    /**
     * Post a message of level DEBUG
     *
     * @param string $message . The log message. This parameter is required.
     */
    public function debug($message)
    {
        $this->logger->debug($message);
    }
}

