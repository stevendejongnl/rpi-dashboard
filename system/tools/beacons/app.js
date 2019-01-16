'use strict';

const NOBLE = require('noble');
const BEACON_SCANNER = require('node-beacon-scanner');

let scanner = new BEACON_SCANNER();

scanner.onadvertisement = (advertisement) => {
	let beacon = advertisement['iBeacon'];
	beacon.rssi = advertisement['rssi'];
	console.log(JSON.stringify(beacon, null, "    "))
};

scanner.startScan().then(() => {
	console.log('Scanning for BLE devices...');
}).catch((error) => {
	console.error(error);
});
