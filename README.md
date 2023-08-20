#💰 DDD-Payouts

##Project proof of concept
Create simple payouts DDD project with authorization and bundling service based on domain events and additional queues, as microservices monolith app.

##Project structure

DDD code is stored in the `src` folder.

```bash
src
├── EventLogger
│   ├── Domain
│   ├── Infrastructure
│   └── Repository
├── Authorization
│   ├── Domain
│   ... To be continued
├── Payout
│   ├── Command
│   ├── Domain
│   ├── Infrastructure
│   ├── Query
│   └── Repository
└── Shared
    ├── Domain
    └── Infrastructure
```

DDD integration code is stored in the `app` folder.

```bash
app
├── Cli
├── Controller
... To be continued
```
Project is dockerized and should be easy to set up locally, for more info please take a look on Makefile.