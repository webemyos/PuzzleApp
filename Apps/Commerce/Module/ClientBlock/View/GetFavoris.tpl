<div class="heading-container heading-resize heading-no-button">
    <div class="heading-background heading-parallax bg-2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                        <br><br><br><br><br><br><br>
                        </div>
                </div>
            </div>
        </div>
</div>
<div class='row'>
    <div class='col-md-2'></div>
    <div class='col-md-10'>
        <h3 class='borderbottom'><i class='fa fa-2x fa-heart-o'>&nbsp</i>{{GetCode(MyFavoris)}}</h3>
    </div>
    <div class='col-md-2'></div>
    <div id='dvUser' class='col-md-8 main-wrap '>
          <ul class='products' id='lstProduct' >
        {{foreach}}
            <ol class="product col-md-4"  style='text-align: center;'>
                 <div class="product-container ">
                    <figure>
                        <div class="product-wrap">
                            <div class="product-images" >
                                <div>
                                <h4 class='borderbottom'>{{element->Product->Value->NameProduct->Value}}</h4>
                                </div>
                                <div class="shop-loop-thumbnail" style='min-height: 300px; max-height:300px;height:300px;max-width: 300px;overflow:hidden'>
                                     
                                     {{element->Product->Value->GetImage()}}
                                </div>
                                     
                            </div>
                            </div>
                    </figure>
                 </div>
                <figcaption>
                
                    <button class='btn btn-primary' onclick="VenteGivreeAction.Dislike(this, {{element->IdEntite}});">{{GetCode(Delete)}}</button>
                    
                </figcaption>
            </ol>
        {{/foreach}}
          </ul>
    </div>
    <div class='clear'></div>
</div>
    

