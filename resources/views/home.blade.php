<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }} - A beacon for AvaIre selfhosted bots</title>

    <link rel="stylesheet" type="text/css" href="https://bootswatch.com/4/flatly/bootstrap.min.css"></link>
    <style type="text/css">
        h1 {
            text-align: center;
            padding-top: 45px;
            padding-bottom: 25px;
        }
        .clearfix {
            clear: both;
            padding-bottom: 20px;
        }
        a.try {
            float: right;
        }
        .resource {
            margin-right: 12px;
        }
        .row:last-child {
            margin-bottom: 60px;
        }
    </style>
</head>
<body>
    <div id="app">
        <div class="container"> 
            <div class="row justify-content-center"> 
                <h1>{{ env('APP_NAME') }}</h1>
            </div>

            <div class="row justify-content-center"> 
                <div class="col-md-8"> 
                    <div class="card"> 
                        <div class="card-header">
                            Information
                        </div> 
         
                        <div class="card-body"> 
                            <p>{{ env('APP_NAME') }} is a free and <a href="https://github.com/avaire/beacon">open-source</a> API created by <a href="https://github.com/Senither">Alexis Tan</a>, the API uses a resource-to-cost rate limit, with unauthorized requested getting 60 resources per minute, different API endpoints will cost more resources than others, you can see what an endpoint costs below. If you'd like to use the API with more resources available, shoot me a message on Discord at <a href="https://discord.gg/ZgPUtcs">https://discord.gg/ZgPUtcs</a> or at <code>Senither#0001</code> to get an API token with a raised limit.</p>

                            <p>You can see your request limit and amout of requests you have left by checking for the <code>X-RateLimit-Limit</code> and the <code>X-RateLimit-Remaining</code> headers.</p>
                        </div> 
                    </div> 
                </div> 
            </div>

            <div class="clearfix"></div>

            <div class="row justify-content-center"> 
                <div class="col-md-8"> 
                    <div class="card"> 
                        <div class="card-header">
                            Get Stats
                            <span class="btn btn-sm btn-primary resource float-right">Costs <strong>1</strong> Resource</span>
                        </div> 
         
                        <div class="card-body"> 
                            <p>Gets stats collected by Beacon, like the total amount of self-hosted bots, and the total combined servers, channels, and users between all the bots.</p>

                            <p><span class="btn btn-sm btn-success">GET</span> <code>/v1/stats</code></p>
                            <p><strong>Example:</strong></p>
                            <p>
                                <code>{{ env('APP_SITE') }}v1/stats</code>
                            </p>
                        </div> 
                    </div> 
                </div> 
            </div>

            <div class="clearfix"></div>

            <div class="row justify-content-center"> 
                <div class="col-md-8"> 
                    <div class="card"> 
                        <div class="card-header">
                            Get Bot
                            <span class="btn btn-sm btn-primary resource float-right">Costs <strong>5</strong> Resources</span>
                        </div> 
         
                        <div class="card-body"> 
                            <p>Gets the information about the bot with the given ID.</p>

                            <p><span class="btn btn-sm btn-success">GET</span> <code>/v1/bot/:id</code></p>
                            <p><strong>Example:</strong></p>
                            <p>
                                <code>{{ env('APP_SITE') }}v1/bot/275270122082533378</code>
                            </p>
                        </div> 
                    </div> 
                </div> 
            </div>

            <div class="clearfix"></div>

            <div class="row justify-content-center"> 
                <div class="col-md-8"> 
                    <div class="card"> 
                        <div class="card-header">
                            Update Bot
                            <span class="btn btn-sm btn-primary resource float-right">Costs <strong>30</strong> Resources</span>
                        </div> 
         
                        <div class="card-body"> 
                            <p>Updates the bot with a given payload, this endpoint is only intended for use by <a href="https://github.com/avaire/avaire">AvaIre</a>.
                            <br>The payload must be sent with a valid Ava user-agent and content-type header, along with a JSON post body that contains a valid <code>shard</code> and <code>bot</code> object.</p>

                            <p><span class="btn btn-sm btn-info">POST</span> <code>/v1/bot/:id</code></p>
                            <p><strong>Example:</strong></p>
                            <p>
                                <code>{{ env('APP_SITE') }}v1/bot/275270122082533378</code>
                            </p>
                        </div> 
                    </div> 
                </div> 
            </div>
        </div> 
    </div>
</body>
</html>