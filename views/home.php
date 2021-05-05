<div class="source">
        <div class="main-container">
        <form action="/home" method="POST" enctype="multipart/form-data">
            <h1 itemprop="name">New paste</h1>
            <div class="form">
                <textarea name="content" id="text-area" cols="30" rows="10"></textarea>
             </div>
        
            <h1 itemprop="name">Optional settings</h1>
            <div class="line"></div>
            <div class="settings">
                <label itemprop="name" id="Highlight">Syntax highlight:</label>
                <select id="syntax-highlight" name="highlight">
                    <option value="None" selected >None</option>
                    <option value="C++">C++</option>
                    <option value="Haskell">Haskell</option>
                    <option value="Java">Java</option>
                </select>

                <label itemprop="name" id="Expiration">Paste expiration:</label>
                <select itemscope itemtype="https://schema.org/Date" id="paste-expiration" name="expiration">
                    <option itemprop="expires" value="1day">1 day</option>
                    <option itemprop="expires" value="7days">7 days</option>
                    <option itemprop="expires" value="14days">14 days</option>
                </select>

                <label itemprop="name" id="Past-Exposure">Paste Exposure:</label>
                <select id="paste-exposure" name="access_modifier">
                    <option value="Public" selected >Public</option>
                    <option value="Private">Private</option>
                </select> 

                <label itemprop="name" id="Password">Password (optional):</label>
                <input type="password" id="fname" name="password">

                <label itemprop="name" id="Burn">Burn after read:</label>
                <input type="checkbox" name="burn_after_read" id="burn">

                <label itemprop="name">Paste Name/Title:</label>
                <input type="text" name="title" required>
            


                <label itemprop="name" id="submit-l"></label>
                <input id="submit" type="submit" value="Create New Paste">
            
            </div>
        </form>
                
        

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
            </div> <!--div for my-pastes!-->

            
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
            </div> <!--div for public-pastes!-->
        </div>
    </div> <!--div from source!!-->