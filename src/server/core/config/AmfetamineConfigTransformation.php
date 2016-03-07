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

class AmfetamineConfigTransformation implements ConfigLoaderTransformerInterface
{
    /**
     * Apply transformation for Engine Configuration
     *
     * @param array $data
     * @return array. Transformed config array
     */
    public function transform($data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value))
                $return [$key] = $this->transform($value);
            else
                $return [$key] = $this->expandVariables($value);
        }
        return ($return);
    }

    /**
     * Expands variables in configuration file
     *
     * @param string $source
     * @return string
     */
    protected function expandVariables($source)
    {
        static $rootFolder;
        if (is_null($rootFolder))
            $rootFolder = AmfetamineServer::getInstance()->getRootPath();
        if (!is_null($source)) {
            $destination = str_replace("{root}", $rootFolder, $source);
            return ($destination);
        }
        else
            return ($source);
    }
}

