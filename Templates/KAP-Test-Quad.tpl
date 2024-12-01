<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="KAP PHP Quad Layout, 03-19-2024">
        <title>{text id="Title"}</title>
        <link href="CSS/KAP-Test-Quad.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <main>
            <section class="SectionQuad">
                <div class="TopLeft">
                    <p>{text id="TopLeft1"}</p>
                    <p>{text id="TopLeft2"}</p>
                    <p>{text id="TopLeft3"}</p>
                    <p>{text id="TopLeft4"}</p>
                </div>
                <div class="TopRight">
                    <p>{text id="TopRight1"}</p>
                    <p>{text id="TopRight2"}</p>
                    <p>{text id="TopRight3"}</p>
                    <p>{text id="TopRight4"}</p>
                    </div>
                <div class="BottomLeft">
                    <p>{text id="BottomLeft1"}</p>
                    <p>{text id="BottomLeft2"}</p>
                    <p>{text id="BottomLeft3"}</p>
                    <p>{text id="BottomLeft4"}</p>
                </div>
                <div class="BottomRight">
                    <p>{text id="BottomRight1"}</p>
                    <p>{text id="BottomRight2"}</p>
                    <p>{text id="BottomRight3"}</p>
                    <p>{text id="BottomRight4"}</p>
                    <p>{select id="BottomRight5"}</p>
                    <select name=user>
                        {html_options values=$id|default: '1' output=$Result|default: ''}
                    </select>
                </div>
            </section>
        </main>
    </body>
</html>
