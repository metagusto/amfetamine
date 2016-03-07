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

class Date extends DateTime
{
    protected $serialized;
    protected static $defaultTimeZone = null;

    /**
     * Default constructor
     */
    public function __construct($time = "now", DateTimeZone $timezone = null)
    {
        if (is_null($timezone))
            $timezone = $this->getDefaultTimeZone();
        parent::__construct($time, $timezone);
    }

    /**
     * Returns true if current date instance represent a date before the one
     * inside $otherDate
     *
     * @param Date $otherDate
     * @return boolean
     */
    public function isBefore(Date $otherDate)
    {
        //$otherDate = clone ($otherDate);
        //$otherDate->setTimezone($this->getTimezone());
        //if ($this->format("U") < $otherDate->format("U"))
        if ($this < $otherDate)
            return (true);
        else
            return (false);
    }

    /**
     * Returns true if current date instance represent a date after the one
     * inside $otherDate
     *
     * @param Date $otherDate
     * @return boolean
     */
    public function isAfter(Date $otherDate)
    {
        //$otherDate = clone ($otherDate);
        //$otherDate->setTimezone($this->getTimezone());
        //if ($this->format("U") > $otherDate->format("U"))
        if ($this > $otherDate)
            return (true);
        else
            return (false);
    }

    /**
     * Explicit string conversion
     *
     * @return string
     */
    public function toString()
    {

        return ($this->__toString());
    }

    /**
     * ToString Magic Method
     *
     * @return string
     */
    function __toString()
    {
        return ($this->format(DATE_ATOM));
    }

    public function addMinutes($amount)
    {
        $this->modify("+$amount minute" . $this->appendPlural($amount));
    }

    public function subtractMinutes($amount)
    {
        $this->modify("-$amount minute" . $this->appendPlural($amount));
    }

    public function addDays($amount)
    {
        $this->modify("+$amount day" . $this->appendPlural($amount));
    }

    public function subtractDays($amount)
    {
        $this->modify("-$amount day" . $this->appendPlural($amount));
    }

    public function addSeconds($amount)
    {
        $this->modify("+$amount second" . $this->appendPlural($amount));
    }

    public function substractSeconds($amount)
    {
        $this->modify("-$amount second" . $this->appendPlural($amount));
    }

    public function addHours($amount)
    {
        $this->modify("+$amount hour" . $this->appendPlural($amount));
    }

    public function substractHours($amount)
    {
        $this->modify("-$amount hour" . $this->appendPlural($amount));
    }

    public function addMonths($amount)
    {
        $this->modify("+$amount month" . $this->appendPlural($amount));
    }

    public function substractMonts($amount)
    {
        $this->modify("-$amount month" . $this->appendPlural($amount));
    }

    public function addYears($amount)
    {
        $this->modify("+$amount year" . $this->appendPlural($amount));
    }

    public function substractYears($amount)
    {
        $this->modify("-$amount year" . $this->appendPlural($amount));
    }

    public function addWeeks($amount)
    {
        $this->modify("+$amount week" . $this->appendPlural($amount));
    }

    public function substractWeeks($amount)
    {
        $this->modify("-$amount week" . $this->appendPlural($amount));
    }

    public function diff(Date $other = null)
    {
        $diff = array("days" => 0, "hours" => 0, "minutes" => 0);
        if (is_null($other))
            return ($diff);
        else {
            // here; calculating
            $dateDiff = $this->format("U") - $other->format("U");;
            $fullDays = floor($dateDiff / (60 * 60 * 24));
            $fullHours = floor(($dateDiff - ($fullDays * 60 * 60 * 24)) / (60 * 60));
            $fullMinutes = floor(($dateDiff - ($fullDays * 60 * 60 * 24) - ($fullHours * 60 * 60)) / 60);
            $diff["days"] = $fullDays;
            $diff["hours"] = $fullHours;
            $diff["minutes"] = $fullMinutes;
            return ($diff);
        }
    }

    /**
     * Returns default timezone cached internally
     *
     * @return DateTimeZone
     */
    protected function getDefaultTimeZone()
    {
        if (is_null(self::$defaultTimeZone)) {
            date_default_timezone_set("Europe/Rome");
            self::$defaultTimeZone = new DateTimeZone(date_default_timezone_get());
        }
        return (self::$defaultTimeZone);
    }

    /**
     * Returns string formatted according european format
     *
     * @param string $div
     * @return string
     */
    public function toEuropeanFormat($div = "/")
    {
        return ($this->format("d" . $div . "m" . $div . "Y"));
    }

    /**
     * Returns string formatted according american format
     *
     * @param string $div
     * @return string
     */
    public function toAmericanFormat($div = "/")
    {
        return ($this->format("m" . $div . "d" . $div . "Y"));
    }

    /**
     * Service function for date calculations
     *
     * @param integer $amount
     * @return string
     */
    protected function appendPlural($amount)
    {
        if ($amount > 1)
            return ("s");
        else
            return ("");
    }

    /**
     * Serialization fix
     *
     * @return array
     */
    public function __sleep()
    {
        $this->serialized = $this->format('c');
        return array('serialized');
    }

    /**
     * Unserialization fix
     */
    public function __wakeup()
    {
        $this->__construct($this->serialized, null);
    }
}

