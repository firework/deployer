<!DOCTYPE html>
<html>
    <head>
        <title>Deploy</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">DeployeR</div>
                <form method="POST" action="deploy">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div>
                        <label>Select a server:</label>
                        <select name="server">
                            @foreach ($servers as $server)
                                <option>{{ $server }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label>Select a branch:</label>
                        <select name="branch">
                            @foreach ($branches as $branch)
                                <option>{{ $branch }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit">Deploy it!</button>
                </form>
            </div>
        </div>
    </body>
</html>
