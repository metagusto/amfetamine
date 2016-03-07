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

class ShowFatalErrorView extends AbstractAmfetamineView
{
    const TEMPLATE_NAME = 'fatal-error-template.htm';
    /**
     * Member variable for property Title.
     *
     * @var string
     */
    protected $title = null;
    /**
     * Member variable for property Message.
     *
     * @var string
     */
    protected $message = null;
    /**
     * Member variable for property Stacktrace.
     *
     * @var array
     */
    protected $stacktrace = array();

    /**
     * Getter method for the member Title.
     *
     * @author metagûsto
     * @return string The value of Title.
     */
    public function getTitle()
    {
        return ($this->title);
    }

    /**
     * Setter method for the member Title.
     *
     * @author metagûsto
     * @param  string $value The value set to Title
     * @return void
     */
    public function setTitle($value)
    {
        $this->title = $value;
    }

    /**
     * Getter method for the member Message.
     *
     * @author metagûsto
     * @return string The value of Message.
     */
    public function getMessage()
    {
        return ($this->message);
    }

    /**
     * Setter method for the member Message.
     *
     * @author metagûsto
     * @param  string $value The value set to Message
     * @return void
     */
    public function setMessage($value)
    {
        $this->message = $value;
    }

    /**
     * Getter method for the member Stacktrace.
     *
     * @author metagûsto
     * @return array The value of Stacktrace.
     */
    public function getStacktrace()
    {
        return ($this->stacktrace);
    }

    /**
     * Setter method for the member Stacktrace.
     *
     * @author metagûsto
     * @param  array $value The value set to Stacktrace
     * @return void
     */
    public function setStacktrace(array $value = null)
    {
        $this->stacktrace = $value;
    }

    /**
     * Performs view show
     */
    public function render()
    {
        $content = $this->loadTemplate(self::TEMPLATE_NAME);
        $content = $this->replaceItem($content, 'title', $this->getTitle());
        $content = $this->replaceItem($content, 'message', $this->getMessage());
        //@FIXME: Si tratta di un array-di-array
        $content = $this->replaceItem($content, 'stacktrace', implode("\n", $this->getStacktrace()));
        return ($content);
    }
}
