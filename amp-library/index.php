<?php
include ('vendor/autoload.php');
use Lullabot\AMP\AMP;
use Lullabot\AMP\Validate\Scope;

// Create an AMP object
$amp = new AMP();
$html =
    '<p>It&#39;s unusual to see innovative promotion techniques used in Malayalam movies.</p>

<p style="text-align: justify;">Right from the first look poster to the promo videos, the team behind Mariyam Vannu Vilakkoothi&nbsp; (MVV) has managed to generate a buzz.&nbsp;</p>

<p style="text-align: justify;">The movie which is gearing up for release on January 31 is directed by debutant Jenith Kachappilly and produced by Rajesh Augustine. Talking to The New Indian Express, Jenith shares some interesting aspects of the movie.</p>

<p style="text-align: justify;"><strong>ALSO WATCH:</strong></p>

<p><iframe allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="" frameborder="0" height="450" src="https://www.youtube.com/embed/m4ABVlLikEk" width="100%"></iframe></p>

<h4 style="text-align: justify;"><strong>Out-Of-The-Box Entertainment</strong></h4>

<p style="text-align: justify;">&quot;This movie offers&nbsp;out-of-the-box entertainment. If the audience watches the film with a light-hearted mindset, they will&nbsp;enjoy it. In our daily life, we come across a lot of simple twists and turns. For example, a person is having a shower and suddenly the water gets over. This will lead to a series of events &mdash; from not being able to complete the bath to getting late for work and so on. Similarly, you will get to see such fun twists in the film. Overall, it will be a light-hearted movie with fresh comedy and ample suspense elements,&quot; says Jenith.</p>

<p style="text-align: justify;"><strong>ALSO WATCH:</strong></p>

<p><iframe allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="" frameborder="0" height="450" src="https://www.youtube.com/embed/VuFK1DJTsI4" width="100%"></iframe></p>

<p style="text-align: justify;">The movie which is also scripted by Jenith revolves around the events at a birthday celebration over a single night at a mansion occupied by four friends. Interestingly, the movie is told through different chapters, unlike the usual comedy movies.</p>

<h4 style="text-align: justify;"><strong>Premam Cast Reunites After Five Years</strong></h4>

<p style="text-align: justify;">MVV reunites Premam cast members Siju Wilson, Sabareesh Varma, Krishna Shankar and Althaf Salim after a gap of five years. Apart from them, noted actress Sethulakshmi (Ittymaani: Made in China, How Old Are You) and directors Sidhartha Siva and Basil Joseph play important roles.</p>

<p style="text-align: justify;">&quot;When I first spoke to the producer Rajesh Augustine about the movie, he suggested that it would be nice if the characters were played by real-life friends. I knew Siju for quite some time and with his help Sabareesh, Krishna and Althaf were on board and the rest is history. For them, it was a sort of vacation and they enjoyed shooting for this movie,&quot; adds Jenith.</p>

<div style="text-align:center">
<figure class="image" style="display:inline-block"><img alt="" height="252" src="https://images.newindianexpress.com/uploads/user/ckeditor_images/article/2020/1/29/MVV2.JPG" width="650" />
<figcaption>MVV reunites Premam cast members Siju Wilson, Sabareesh Varma, Krishna Shankar and Althaf Salim after a gap of five years. ( Youtube screengrab)</figcaption>
</figure>
</div>

<p style="text-align: justify;">Sethulakshmi plays the central role of Mariyama George in MVV. Jenith says, &quot;She is the title character. Mariyama George will surely remind everyone of the characters played by late actress Sukumari from classic movies like Boeing Boeing and Vandanam. Right from the beginning, I felt Sethulakshmi <em>chechi</em> could do justice to the character and everyone on the sets felt that she nailed the role. It could be one of the best characters she has played so far,&rdquo; he said.&nbsp;</p>

<div style="text-align:center">
<figure class="image" style="display:inline-block"><img alt="" height="252" src="https://images.newindianexpress.com/uploads/user/ckeditor_images/article/2020/1/29/MVV3.JPG" width="650" />
<figcaption>Noted actress Sethulakshmi along with the main star cast of MVV.( Youtube screengrab)</figcaption>
</figure>
</div>

<h4 style="text-align: justify;"><strong>From Mandakini to Mariyam Vannu Vilakkoothi</strong></h4>

<p style="text-align: justify;">Initially, the name of the movie was Mandakini but it was later changed.</p>

<p style="text-align: justify;">&quot;The first name that I had in mind was Mariyam Vannu Vilakkoothi, but later we decided to have a short and crisp name and that&#39;s how Mandakini was chosen. Then the movie got delayed and, meanwhile, movies like Mandharam and Dakini also got released. So we decide to change the title from Mandakini to MVV to avoid unnecessary confusion,&quot; says Jenith.</p>

<h4 style="text-align: justify;"><strong>Creative Promotion Drive</strong></h4>

<p style="text-align: justify;">MVV has come out with some novel&nbsp;techniques to promote the movie,&nbsp;something we don&#39;t usually see in the Malayalam film industry.&nbsp;</p>

<p style="text-align: justify;">&quot;Right from the pre-production, I had asked my producer to give me complete freedom to try out different promotion techniques for digital marketing. This movie had a lot of scope for online promotion and I feel we have made good use of it,&quot; Jenith adds.</p>

<p style="text-align: justify;">Apart from the creative promos and posters, Jenith along with his MVV team had organised two movie workshops in Kochi for movie enthusiasts. The workshop focused on the struggles faced by first time filmmakers.</p>

<p style="text-align: justify;"><strong>ALSO WATCH:</strong></p>

<p><iframe allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="" frameborder="0" height="450" src="https://www.youtube.com/embed/rDovDfvw1Rc" width="100%"></iframe></p>

<p style="text-align: justify;">For the last couple of weeks, MVV has made its presence felt on social media. &nbsp;</p>

<p style="text-align: justify;">From the first look which was unveiled by Fahadh Faasil to the latest promo videos, MVV has veered off the beaten track. In the last four days, four different promos were released online by various celebrities.&nbsp;</p>

<p style="text-align: justify;">MVV&rsquo;s cinematography is handled by Shinoj P Ayyappan while debutants Wazim-Murali compose the music and the editing is by Appu N Bhattathiri. The film is distributed by ARK Release.</p>

';
$amp->loadHtml($html);
$amp_html = $amp->convertToAmpHtml();

// Print AMP HTML
print($amp_html);