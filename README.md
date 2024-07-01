# Transaction service

## Fee calculator for transactions
- Start redis server with command `redis-server` for local testing
- Run command `bin/console transaction:fee:calculate` with argument `transactions.txt`

## Bin providers
- Added two providers because lookup bin provider fails sometimes. 
  - https://lookup.binlist.net/
  - https://api.chargeblast.com/bin/
- We can choose bin provider by our own or configure switching to second provider automatically if first fails(depends on needs).

## Rate provider
- Presented provider in task needs authentication so I found another one.
- Replaced request https://api.exchangeratesapi.io/latest on https://api.frankfurter.app/latest.