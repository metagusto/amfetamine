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
 * DefaultGatewayUrlBuilder
 * -----------------------------------------------------------------------------
 * Default url builder class that builds the remote gateway url starting from
 * the .swf url pointing to a .conf file having the same name of .swf
 *
 * i.e.:
 *   application url: http://amfetamine.metagusto.com/deploy/test.swf
 * gateway built url: http://amfetamine.metagusto.com/deploy/test.conf
 *
 * @author metagûsto
 */
public class DefaultGatewayUrlBuilder implements RemoteGatewayUrlBuilderInterface {
    /**
     * Default constructor
     */
    public function DefaultGatewayUrlBuilder() {
    }

    /**
     * Builds the remote gateway url using this logic:
     * the url is built from the current swf's application url
     * replaced by .conf
     */
    public function build():String {
        var currentUrl:String = Application.application.url;
        currentUrl = currentUrl.replace(".swf", ".conf");
        return (currentUrl);
    }
}
}