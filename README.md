# Transaction service

## Fee calculator for transactions
- Run command `bin/console transaction:fee:calculate` with argument `transactions.txt`

## Bin providers
- Added two providers because lookup bin provider fails sometimes.
- We can choose bin provider by our own or configure switching to second provider automatically if first fails(depends on needs).

## Rate provider
- Presented provider in task needs authentication so I found another one.