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

class NetHelper
{
    const SSL_PORT = 443;

    /**
     * Returns the host (name or IP address) part from a given Url
     *
     * @param string $url
     * @return string|null
     */
    public static function getHostFromUrl($url)
    {
        $parts = @parse_url($url);
        if (!($parts === false) && array_key_exists("host", $parts))
            return ($parts["host"]);
        else
            return (null);
    }

    /**
     * Returns client Ip Address
     *
     * @return String
     */
    public static function getClientIp()
    {
        $ip = null;
        if (getenv("HTTP_CLIENT_IP"))
            $ip = getenv("HTTP_CLIENT_IP");
        else {
            if (getenv("HTTP_X_FORWARDED_FOR"))
                $ip = getenv("HTTP_X_FORWARDED_FOR");
            else {
                if (getenv("REMOTE_ADDR"))
                    $ip = getenv("REMOTE_ADDR");
                else
                    $ip = "UNKNOWN";
            }
        }
        return $ip;
    }

    /**
     * @return bool
     */
    public static function isHttpsMode()
    {
        static $isHttpsMode;
        if (!is_null($isHttpsMode))
            return ($isHttpsMode);
        if (array_key_exists("HTTPS", $_SERVER)) {
            return (true);
        }
        else {
            // checking prot
            if ($_SERVER["SERVER_PORT"] == self::SSL_PORT)
                return (true);
            else
                return (false);
        }
    }

    /**
     * @return string
     */
    public static function getRootUrlPath()
    {
        static $rootUrlFolder;
        if (is_null($rootUrlFolder)) {
            // Calculating Relative path
            $rootUrlFolder = dirname($_SERVER['PHP_SELF']);
            if (strlen($rootUrlFolder) > 0)
                $rootUrlFolder = substr($rootUrlFolder, 1);
        }
        return ($rootUrlFolder);
    }
}

