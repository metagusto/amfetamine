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

class Path
{
    public static function combine($path1, $path2, $unixLike = true)
    {
        if ($unixLike)
            $slash = "/";
        else
            $slash = "\\";
        if (substr($path1, strlen($path1) - 1, 1) != $slash) {
            $path1 .= $slash;
        }
        return ($path1 . $path2);
    }

    public static function getNameOfFile($file)
    {
        for ($index = (strlen($file) - 1); $index > -1; $index--) {
            $char = $file[$index];
            if ($char == ".") {
                return (substr($file, 0, $index - strlen($file)));
            }
        }
        return ($file);
    }

    public static function getExtensionOfFile($file)
    {
        $buffer = "";
        for ($index = (strlen($file) - 1); $index > -1; $index--) {
            $char = $file[$index];
            if ($char == ".") {
                return ($buffer);
            }
            else {
                $buffer = $char . $buffer;
            }
        }
        return ("");
    }

    public static function getFilenameFromPath($path)
    {
        return (basename($path));
    }
}
