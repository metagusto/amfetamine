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

/**
 * RemoteGatewayLocator
 * -----------------------------------------------------------------------------
 * This class is used to automatically detect and locate the remote gateway
 * the flash application should call and connect to.
 *
 * @author metagûsto
 */
public class RemoteGatewayLocator {
    protected var _urlBuilder:RemoteGatewayUrlBuilderInterface;

    /**
     * Class constructor
     *
     * @param gatewayUrlBuilder The RemoteGatewayUrlBuilderInterface instance used to build url
     * @return void
     */
    public function RemoteGatewayLocator(gatewayUrlBuilder:RemoteGatewayUrlBuilderInterface = null):void {
        this.urlBuilder = gatewayUrlBuilder;
    }

    /**
     * Locates the remote gateway url
     *
     * @return String The gateway url
     */
    public function locate():String {
        return (this.urlBuilder.build());
    }

    /**
     * Returns the url builder instance
     *
     * @return RemoteGatewayUrlBuilderInterface The builder instance
     */
    public function get urlBuilder():RemoteGatewayUrlBuilderInterface {
        return (this._urlBuilder);
    }

    /**
     * Sets the RemoteGatewayUrlBuilderInterface instance used to build the remote url
     *
     *  @param builder
     */
    public function set urlBuilder(builder:RemoteGatewayUrlBuilderInterface):void {
        if (builder == null)
            this._urlBuilder = new DefaultGatewayUrlBuilder();
        else
            this._urlBuilder = builder;
    }
}
}