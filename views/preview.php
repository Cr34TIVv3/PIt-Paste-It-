<div class="source">
    <div class="main-container">

        <h1><?php echo $record->title; ?></h1>


        <div class="content">
            <pre>
                <code>
                    <?php echo $record->content; ?>
                </code>
            </pre>
        </div>


        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.7.2/styles/default.min.css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.7.2/highlight.min.js"></script>
        <script>hljs.highlightAll();</script>



        <h1 itemprop="name">My pastes</h1>
        <div class="line"></div>

        <div class="my-pastes">
            <table itemscope itemtype="https://schema.org/Table">
                <tr>
                    <th>Titlu</th>
                    <th>Date</th>
                    <th>Expires</th>
                    <th>Syntax</th>
                    <th>Visibility</th>
                </tr>
                <tr>
                    <td>Tuxy</td>
                    <td>21.02.2019</td>
                    <td>Never</td>
                    <td>Java</td>
                    <td>Private</td>
                </tr>
                <tr>
                    <td>Pinguinescu</td>
                    <td>21.01.2020</td>
                    <td>Never</td>
                    <td>C++</td>
                    <td>Public</td>
                </tr>
                <tr>
                    <td>Pinguin</td>
                    <td>21.01.2020</td>
                    <td>Never</td>
                    <td>C++</td>
                    <td>Public</td>
                </tr>
            </table>
        </div>
        <!--div for my-pastes!-->


        <h1 itemprop="name">Public posts</h1>
        <div class="line"></div>
        <div class="public-pastes">
            <div class="paste-obj">
                <h3>Tuxi</h3>
                <p>some description</p>
            </div>
            <div class="paste-obj">
                <h3>my latest paste1</h3>
                <p>some description1</p>
            </div>
            <div class="paste-obj">
                <h3>my latest paste2</h3>
                <p>some description2</p>
            </div>
        </div>
        <!--div for public-pastes!-->

    </div>
</div>
<!--div from source!!-->