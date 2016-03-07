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

interface ClassMapperInterface
{
    /**
     * Build an associative array used to map a local
     * class to a remote map.
     * The array should have this structure:
     * array['localname']['remotename']
     * where:
     *        localname    is the class name in PHP
     *        remotename    is the class name in ActionScript
     * example:
     * ['com.metagusto.package.LocalPhpClass']['com.metagusto.package.RemoteAsClass']
     *
     * @author metagûsto
     * @return array
     */
    public function execute();
}
