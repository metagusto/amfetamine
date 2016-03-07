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

class MissingConfigException extends Exception
{
    /**
     * Default constructor
     *
     * @param string $expectedConfigFile
     * @param mixed $code
     */
    public function __construct($expectedConfigFile, $code = null)
    {
        parent::__construct("Missing configuration file '$expectedConfigFile'", $code);
    }
}
