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
package com.metagusto.logging {

import flash.events.ErrorEvent;

import mx.rpc.events.FaultEvent;

/**
 * RemoteLogErrorEvent
 * -----------------------------------------------------------------------------
 * This class implements a the exception raised on remote delivery failure
 *
 * @author metagûsto
 */
public class RemoteLogErrorEvent extends ErrorEvent {
    protected var _remoteFaultEvent:FaultEvent;

    /**
     * Default constructor
     */
    public function RemoteLogErrorEvent(message:String, remoteFaultEvent:FaultEvent):void {
        message = "Unable to remotely deliver log message: " + message;
        this._remoteFaultEvent = remoteFaultEvent;
        super(ErrorEvent.ERROR, false, false, message);
    }

    /**
     * Returns remote fault event
     */
    public function get remoteFaultEvent():FaultEvent {
        return (this._remoteFaultEvent);
    }
}
}