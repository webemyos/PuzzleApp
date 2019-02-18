<section class="row page-cover" data-bgimage="{{GetPath(/images/page-cover/5.jpg)}}">
  		<div class="row m0">
  			<div class="container">
				<h2 class="page-title">Demander un devis</h2>
			</div>
  		</div>
  	</section>
  	
  	<!--Contact Form Area-->
  	<section class="row contact-form-area">
  		<div class="container">
                    {{if success == false}}
  			<div class="row sectionTitle text-left">
  				<h2 class="this-title">Vous êtes prêt à lancer le projet ?</h2>
  				<p>Contactez nous afin d'en discuter !</p>
  			</div>
  			<p class="contact-text">Que vous en soyez au stade de l'idée ou avec un business plan complet, nous avons surêment une solution à vous proposer.</p>
  			<div class="row contact-form-box">
  				<form method='post' action="{{GetPath(/Devis/Ask)}}" id="contactForm" class="row contact-form">
  					<div class="col-sm-6 form-group"><input type="text" id="name" name="name" placeholder="Nom Complet" required class="form-control"></div>
  					<div class="col-sm-6 form-group"><input type="email" id="email" name="email" placeholder="Adresse Email" required class="form-control"></div>
  					<div class="col-sm-6 form-group"><input type="text" id="subject" name="subject" placeholder="Sujet" required class="form-control"></div>
  					<div class="col-sm-6 form-group"><input type="tel" id="phone" name="phone" placeholder="Téléphone" class="form-control"></div>
  					<div class="col-sm-12 form-group"><textarea name="message" id="<" class="form-control" placeholder="Votre projet"></textarea></div>
  					<div class="col-sm-12"><input type="submit" value="Soumettre" class="btn btn-primary"></div>
  				</form>
  			</div>
                    {{/if success == false}}
                    
                    {{if success == true}}
                    	<div class="row sectionTitle text-left">
  				<h2 class="this-title">Enregistrement de votre demande.</h2>
  				<p>Votre message à bien été envoyé nous vous rappelerons dans les plus bref délais.</p>
  			</div>
                        <div style='height:200px'></div>
                        
                    {{/if success == true}}
  		</div>
  	</section>
  	