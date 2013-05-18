<?php
/**
 * Widget for displaying the footer. Must not be used without using the header as well
 */
class Widget_Footer extends Widget {

  public function __construct() {
  
  }

  public function ToHtml() {
    return <<<FOOTER
    
					</section>
				</article>
    		</section>
			<footer>
				<a onclick="window.scrollTo(0,0); return false;" title="To page top" id="back_to_top" href="#site" tabindex="-1">Back to top</a>
				<span id="copyright">Copyright Oz © 2013</span>
			</footer>
		</div>
	</body>
</html>
FOOTER;
  }
}
