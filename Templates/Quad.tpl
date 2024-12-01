<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="ModeliXe Quad Layout with Bloc, 11-19-2024">
        <title>{text id="Title"}</title>
        <link href="CSS/Quad.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <main>
            <section class="SectionQuad">
                <div class="TopLeft">
                    <p>
                        {text id="TopLeft1"}
                    </p>
                    <p>
                        {text id="TopLeft2"}
                    </p>
                    <p>
                        {text id="TopLeft3"}
                    </p>
                    <p>
                        {text id="TopLeft4"}
                    </p>
                    <p>
                        {start id="BlocTopLeft"}
                        <span>Booper!</span>
                        {end id="BlocTopLeft"}
                    </p>
                </div>

                <div class="TopRight">
                    <p>
                        {text id="TopRight1"}
                    </p>
                    <p>
                        {text id="TopRight2"}
                    </p>
                    <p>
                        {start id="BlocTopRight"}
                            <div>
                                {text id="TopRight3"}
                            </div>
                            <div>
                                {text id="TopRight4"}
                            </div>
                        {end id="BlocTopRight"}
                    </p>
                </div>

                <div class="BottomLeft">
                    <p>
                        {text id="BottomLeft1"}
                    </p>
                    <p>
                        {text id="BottomLeft2"}
                    </p>
                    <p>
                        {text id="BottomLeft3"}
                    </p>
                    <p>
                        {start id="BlocBottomLeft"}
                            {text id="BottomLeft4"}
                        {end id="BlocBottomLeft"}
                    </p>
                </div>

                <div class="BottomRight">
                    <p>
                        {text id="BottomRight1"}
                    </p>
                    <p>
                        {text id="BottomRight2"}
                    </p>
                    <p>
                        {text id="BottomRight3"}
                    </p>
                    <p>
                        {text id="BottomRight4"}
                    </p>
                    <p>
                        {start id="BlocBottomRight"}
                        {end id="BlocBottomRight"}
                    </p>
                    <p>
                        <label for="{text id="LabelFor"}">Sample Select: </label>
                        {select id="BottomRight5"}
                    </p>
                </div>
            </section>
        </main>
    </body>
</html>
