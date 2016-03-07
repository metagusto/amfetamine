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

class LoggerFileAppender extends Zend_Log_Writer_Stream
{
    /**
     * @param mixed $streamOrUrl
     * @param string $mode
     */
    public function __construct($streamOrUrl, $mode = 'a')
    {
        parent::__construct($streamOrUrl, $mode);
        $formatter = new Zend_Log_Formatter_Simple("%timestamp% %priorityName% | %message% \n");
        $this->setFormatter($formatter);
    }
}

