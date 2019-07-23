<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_Starter
 */

?>
	</main><!-- #content -->
	<footer class="mt-auto border-top border-light py-5 bg-light">
	  <div class="container">
	    <div class="row align-items-center justify-content-between">
	    	<div class="col-md-8 mb-3 mb-md-0">
					<a class="text-dark d-inline-block mb-3" href="https://www.fitnyc.edu/museum/" id="footer-logo">
	          <img class="mr-1" src="<?php echo get_template_directory_uri() . '/inc/assets/images/FITmuseum_black-gold.png'; ?>" alt="Museum at FIT Logo"/>
	          <span class="align-middle text-uppercase small">Celebrating fashion for 50 years</span>
	        </a>
					<address class="small">
						Museum at the Fashion Institute of Technology
						<br>
						Seventh Avenue at 27 Street
						<br>
						New York City 10001-5992
					</address>
					<p class="small mb-0">
						&copy;<?php echo date("Y"); ?> Fashion Institute of Technology
					</p>
	    	</div>
				<div class="col-md-4 col-lg-3">
					<ul class="list-inline" id="social">
						<li class="list-inline-item">
							<a class="text-dark" href="https://twitter.com/museumatFIT" aria-label="Museum at FIT Twitter">
								<i class="fab fa-twitter fa-lg" aria-hidden="" title="Museum at FIT Twitter"></i>
							</a>
						</li>
			      <li class="list-inline-item">
							<a class="text-dark" href="https://www.facebook.com/TheMuseumAtFIT" aria-label="Museum at FIT Facebook">
								<i class="fab fa-facebook fa-lg" aria-hidden="" title="Museum at FIT Facebook"></i>
							</a>
						</li>

			      <li class="list-inline-item">
							<a class="text-dark" href="http://pinterest.com/museumatfit/" aria-label="Museum at FIT Pinterest">
								<i class="fab fa-pinterest-p fa-lg" aria-hidden="" title="Museum at FIT Pinterest"></i>
							</a>
						</li>
			      <li class="list-inline-item">
							<a class="text-dark" href="https://instagram.com/museumatfit" aria-label="Museum at FIT Instagram">
								<i class="fab fa-instagram fa-lg" aria-hidden="" title="Museum at FIT Instagram"></i>
							</a>
						</li>
			    </ul>
					<p class="text-uppercase mb-1" id="footer-title">
						Exhibitions Timeline
					</p>
					<p class="small mb-0">
						This site is an initiative of the <a class="text-dark" href="https://www.fitnyc.edu/museum/">Museum at FIT</a> and the <a class="text-dark" href="https://www.fitnyc.edu/library/">FIT Library</a>.
					</p>
	    	</div>
	    </div>
	  </div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
