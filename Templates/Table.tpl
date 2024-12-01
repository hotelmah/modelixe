<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="ModeliXe Table Layout with Bloc, 11-19-2024">
        <title>{text id="Title"}</title>
        <link href="CSS/Table.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <main>
            <section class="SectionTable">
                <div class="DivTable">
                    <table>
                        <tr>
                            <th colspan={text id="ColSpanTotal"}>
                                {text id="TableHeaderTop"}
                            </th>
                        </tr>
                        <tr>
                            <td>{text id="tdTextFirstBefore"}</td>
                            <td colspan="{text id="colSpanPartail"}">{text id="tdTextLastBefore"}</td>
                        </tr>

                        <!-- Start loop (boucle) table rows  -->
                        {start id="bloc_loop_table_row"}
                        {end id="bloc_loop_table_row"}
                        <!-- End loop (boucle) table rows  -->

                        <tr>
                            <td>{text id="tdTextFirstAfter"}</td>
                            <td colspan="{text id="colSpanPartail"}">{text id="tdTextLastAfter"}</td>
                        </tr>
                        <tr>
                            <th colspan={text id="ColSpanTotal"}>
                                {text id="TableHeaderBottom"}
                            </th>
                        </tr>
                    </table>
                    <div class="BelowTable">
                        <p>
                            {select id="SelBelowTable"}
                        </p>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>
