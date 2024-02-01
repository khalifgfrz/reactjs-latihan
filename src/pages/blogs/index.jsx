import { useState, useEffect } from "react";

function Blog() {
  const [posts, setPosts] = useState(postsData);

  useEffect(() => {
    fetch("https://jsonplaceholder.typicode.com/todos/1")
      .then((response) => response.json())
      .then((json) => setPosts(json));
  }, []);

  return (
    <>
      <h2>My Blog Posts</h2>
      {posts.map((item, index) => (
        <div key={index}>- {item.title}</div>
      ))}
    </>
  );
}

export default Blog;
