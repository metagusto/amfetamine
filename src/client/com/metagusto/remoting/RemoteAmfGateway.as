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
package com.metagusto.remoting {

import flash.net.NetConnection;
import flash.net.ObjectEncoding;

/**
 * RemoteGateway
 * -----------------------------------------------------------------------------
 * This class is used to automatically detect and locate the remote gateway
 * the flash application should call and connect to.
 *
 * @author metagûsto
 */
public class RemoteAmfGateway extends NetConnection {
    public static const AMF3 = ObjectEncoding.AMF3;
    public static const AMF0 = ObjectEncoding.AMF0;
    protected var _gatewayUrl:String = null;

    /**
     * Class constructor
     */
    public function RemoteAmfGateway(url:String = null, protocol:uint = RemoteAmfGateway.AMF3) {
        // Setting up encoding
        objectEncoding = protocol;
        this._gatewayUrl = url;
        if (url) this.connect(url);
    }

    /**
     * Sets the remote gateway url
     *
     * @param url The gateway url
     */
    public function set gatewayUrl(url:String):void {
        this._gatewayUrl = url;
    }

    /**
     * Returns the gateway url
     *
     * @return String the gateway url
     */
    public function get gatewayUrl():String {
        return (this._gatewayUrl);
    }
}
}