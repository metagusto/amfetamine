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
abstract class AbstractAmfetamineView implements AmfetamineBasicViewInterface
{
    /**
     * Member variable for property TemplatesPath.
     *
     * @var string
     */
    protected $templatesPath = null;

    /**
     * Getter method for the member TemplatesPath.
     *
     * @author metagûsto
     * @return string The value of TemplatesPath.
     */
    public function getTemplatesPath()
    {
        return ($this->templatesPath);
    }

    /**
     * Setter method for the member TemplatesPath.
     *
     * @author metagûsto
     * @param  string $value The value set to TemplatesPath
     * @return void
     */
    public function setTemplatesPath($value)
    {
        $this->templatesPath = $value;
    }

    /**
     * Default constructor
     *
     * @param string $templatePath
     */
    public function __construct($templatePath = null)
    {
        $this->templatesPath = $templatePath;
    }

    /**
     * Shows the view
     */
    public function show()
    {
        print $this->render();
        flush();
    }

    /**
     * Process data and return Html output
     *
     * @return string Html content
     */
    protected abstract function render();

    /**
     * Loads simple template
     *
     * @param $templateName
     * @throws FileNotFoundException
     * @internal param string $filename
     * @return string Template buffer
     */
    protected function loadTemplate($templateName)
    {
        $filename = Path::combine($this->templatesPath, $templateName);
        if (!file_exists($filename))
            throw new FileNotFoundException($filename);
        else
            return (file_get_contents($filename));
    }

    /**
     * Performs hook replacement
     *
     * @param string $buffer
     * @param string $hook An hook name (e.g. place for #place#)
     * @param string $value The value to be replaced
     * @param boolean $encode True if you want encode $value for Html
     * @return string
     */
    protected function replaceItem($buffer, $hook, $value, $encode = true)
    {
        if ($encode) {
            $value = htmlentities($value, null, 'utf-8');
            $value = str_replace("\r\n", "<br />", $value);
            $value = str_replace("\r", "<br />", $value);
            $value = str_replace("\n", "<br />", $value);
        }
        return (str_replace("#$hook#", $value, $buffer));
    }
}
