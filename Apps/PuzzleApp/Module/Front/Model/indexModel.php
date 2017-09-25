

class IndexModel extends Model
{

		 private articles;

		function __construct($core, $blog)
		{
				 //Dernieres articles de blog
			   $blog = new BlogBlog($this->Core);
			   $blog= $blog->GetByName($this->Core->Config->GetKey("BLOG"));
			   $this->articles = BlogHelper::GetLast($this->Core, $blog, 3);
		}
}