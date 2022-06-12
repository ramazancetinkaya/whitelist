/**
 * Returns if the given ip is on the given whitelist.
 *
 * @param string $ip        The ip to check.
 * @param array  $whitelist The ip whitelist. An array of strings.
 *
 * @return bool
 */
function isAllowedIp($ip, array $whitelist)
{
    $ip = (string)$ip;
    if (in_array($ip, $whitelist, true)) {
        // the given ip is found directly on the whitelist --allowed
        return true;
    }
    // go through all whitelisted ips
    foreach ($whitelist as $whitelistedIp) {
        $whitelistedIp = (string)$whitelistedIp;
        // find the wild card * in whitelisted ip (f.e. find position in "127.0.*" or "127*")
        $wildcardPosition = strpos($whitelistedIp, "*");
        if ($wildcardPosition === false) {
            // no wild card in whitelisted ip --continue searching
            continue;
        }
        // cut ip at the position where we got the wild card on the whitelisted ip
        // and add the wold card to get the same pattern
        if (substr($ip, 0, $wildcardPosition) . "*" === $whitelistedIp) {
            // f.e. we got
            //  ip "127.0.0.1"
            //  whitelisted ip "127.0.*"
            // then we compared "127.0.*" with "127.0.*"
            // return success
            return true;
        }
    }
    // return false on default
    return false;
}
