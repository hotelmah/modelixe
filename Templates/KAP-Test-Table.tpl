<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="KAP PHP Table Layout, 10-17-2024">
        <title>{text id="Title"}</title>
        <link href="CSS/KAP-Test-Table.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <main>
            <section class="SectionTable">
                <div class="DivTable">
                    <table>
                        <tr>
                            <th colspan=6>
                                {text id="TableHeaderTop"}
                            </th>
                        </tr>
                        <tr>
                            <td>{text id="TD1"}</td>
                        </tr>
                        <tr>
                            <td>{text id="TD2"}</td>
                        </tr>
                        <!-- loop (boucle) table rows  -->

                        {start id="bloc_loop_table_row"}
                        {end id="bloc_loop_table_row"}

                        <tr>
                            <th colspan=6>
                                {text id="TableHeaderBottom"}
                            </th>
                        </tr>
                    </table>
                    <p>
                        {select id="SelectBelowTable"}
                    </p>
                </div>
            </section>
        </main>
    </body>
</html>
