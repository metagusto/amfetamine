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
class AmfMapHelper
{
    /**
     * @param Date $date
     * @return null|string
     */
    public static function date2amf(Date $date = null)
    {
        if (is_null($date))
            return (null);
        else
            return ($date->format("d/m/Y"));
    }

    /**
     * @param Date $date
     * @return null|string
     */
    public static function time2amf(Date $date = null)
    {
        if (is_null($date))
            return (null);
        else
            return ($date->format("H:i:s"));
    }

    /**
     *
     * @param mixed $value
     * @return Date
     */
    public static function amf2Date($value)
    {
        $date = new Date($value);
        return ($date);
    }
}
