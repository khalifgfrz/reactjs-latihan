import { useState, useEffect } from "react";
import postsData from "../post.json";
import Article from "../components/Article";
import Search from "../components/Search";

function Homepage() {
  const [posts, setPosts] = useState(postsData);
  const [totalPosts, setTotalPosts] = useState(0);

  const onSearchChange = (value) => {
    const filteredPosts = postsData.filter((item) => item.title.includes(value));
    setPosts(filteredPosts);
    setTotalPosts(filteredPosts.length);
  };

  useEffect(() => {
    fetch("https://jsonplaceholder.typicode.com/todos/1")
      .then((response) => response.json())
      .then((json) => setPosts(json));
  }, []);

  return (
    <>
      <h1>Simple Blog</h1>
      <Search onSearchChange={onSearchChange} totalPosts={totalPosts} />
      {posts.map((props, index) => (
        // <Article title={title} tags={tags} date={date} />
        <Article {...props} key={index} />
      ))}
    </>
  );
}

export default Homepage;
