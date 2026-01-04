// Duck-insert
// Profils ///////////////////////////////////////////////////

// Alice
CREATE (:Profil {
  id: "11111111-1111-1111-1111-111111111111",
  name: "Alice",
  image_url: "http://10.0.2.2:8000/storage/public/profils/alice.jpg",
  hash: "$2y$12$abcdefghijklmnopqrstuv",
  created_at: "2024-10-01T00:00:00.000Z",
  updated_at: "2024-10-01T00:00:00.000Z"
});

// Bob
CREATE (:Profil {
  id: "22222222-2222-2222-2222-222222222222",
  name: "Bob",
  image_url: "http://10.0.2.2:8000/storage/public/profils/bob.jpg",
  hash: "$2y$12$abcdefghijklmnopqrstuv",
  created_at: "2024-10-02T00:00:00.000Z",
  updated_at: "2024-10-02T00:00:00.000Z"
});

// Charlie
CREATE (:Profil {
  id: "33333333-3333-3333-3333-333333333333",
  name: "Charlie",
  image_url: "http://10.0.2.2:8000/storage/public/profils/charlie.jpg",
  hash: "$2y$12$abcdefghijklmnopqrstuv",
  created_at: "2024-10-03T00:00:00.000Z",
  updated_at: "2024-10-03T00:00:00.000Z"
});

// Didié
CREATE (:Profil {
  id: "44444444-4444-4444-4444-444444444444",
  name: "Didié",
  image_url: "http://10.0.2.2:8000/storage/public/profils/didie.jpg",
  hash: "$2y$12$abcdefghijklmnopqrstuv",
  created_at: "2024-10-04T00:00:00.000Z",
  updated_at: "2024-10-04T00:00:00.000Z"
});

// Diana
CREATE (:Profil {
  id: "55555555-5555-5555-5555-555555555555",
  name: "Diana",
  image_url: "http://10.0.2.2:8000/storage/public/profils/diana.jpg",
  hash: "$2y$12$abcdefghijklmnopqrstuv",
  created_at: "2024-10-05T00:00:00.000Z",
  updated_at: "2024-10-05T00:00:00.000Z"
});

// Relations FRIEND ///////////////////////////////////////////////////

// Alice → Bob
MATCH (a:Profil {id: "11111111-1111-1111-1111-111111111111"}),
      (b:Profil {id: "22222222-2222-2222-2222-222222222222"})
CREATE (a)-[:FRIEND {created_at: "2024-10-10T00:00:00.000Z"}]->(b);

// Alice → Charlie
MATCH (a:Profil {id: "11111111-1111-1111-1111-111111111111"}),
      (c:Profil {id: "33333333-3333-3333-3333-333333333333"})
CREATE (a)-[:FRIEND {created_at: "2024-10-11T00:00:00.000Z"}]->(c);

// Bob → Diana
MATCH (b:Profil {id: "22222222-2222-2222-2222-222222222222"}),
      (d:Profil {id: "55555555-5555-5555-5555-555555555555"})
CREATE (b)-[:FRIEND {created_at: "2024-10-12T00:00:00.000Z"}]->(d);

// Bob → Didié
MATCH (b:Profil {id: "22222222-2222-2222-2222-222222222222"}),
      (e:Profil {id: "44444444-4444-4444-4444-444444444444"})
CREATE (b)-[:FRIEND {created_at: "2024-10-13T00:00:00.000Z"}]->(e);

// Didié → Bob
MATCH (d:Profil {id: "44444444-4444-4444-4444-444444444444"}),
      (b:Profil {id: "22222222-2222-2222-2222-222222222222"})
CREATE (d)-[:FRIEND {created_at: "2024-10-14T00:00:00.000Z"}]->(b);

// Charlie → Alice
MATCH (c:Profil {id: "33333333-3333-3333-3333-333333333333"}),
      (a:Profil {id: "11111111-1111-1111-1111-111111111111"})
CREATE (c)-[:FRIEND {created_at: "2024-10-15T00:00:00.000Z"}]->(a);

// Posts ////////////////////////////////////////////////////////////

// Hello world!
CREATE (:Post {
  id: "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa",
  description: "Hello world!",
  image_url: "http://10.0.2.2:8000/storage/public/profils/helloworld.jpg",
  created_at: "2024-11-01T00:00:00.000Z",
  updated_at: "2024-11-01T00:00:00.000Z"
});

// Learning Cypher
CREATE (:Post {
  id: "bbbbbbbb-bbbb-bbbb-bbbb-bbbbbbbbbbbb",
  description: "Learning Cypher",
  image_url: "http://10.0.2.2:8000/storage/public/posts/cypher.jpg",
  created_at: "2024-12-01T00:00:00.000Z",
  updated_at: "2024-12-01T00:00:00.000Z"
});

// Enjoying the weather
CREATE (:Post {
  id: "cccccccc-cccc-cccc-cccc-cccccccccccc",
  description: "Enjoying the weather",
  image_url: "http://10.0.2.2:8000/storage/public/profils/weather.jpg",
  created_at: "2024-11-15T00:00:00.000Z",
  updated_at: "2024-11-15T00:00:00.000Z"
});

// Traveling to Paris
CREATE (:Post {
  id: "dddddddd-dddd-dddd-dddd-dddddddddddd",
  description: "Traveling to Paris",
  image_url: "http://10.0.2.2:8000/storage/public/profils/paris.jpg",
  created_at: "2024-11-20T00:00:00.000Z",
  updated_at: "2024-11-20T00:00:00.000Z"
});

// Relations POSTED ///////////////////////////////////////////////////

// Alice → Hello world!
MATCH (a:Profil {id: "11111111-1111-1111-1111-111111111111"}),
      (p:Post {id: "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"})
CREATE (a)-[:POSTED {created_at: "2024-11-01T00:00:00.000Z"}]->(p);

// Bob → Learning Cypher
MATCH (b:Profil {id: "22222222-2222-2222-2222-222222222222"}),
      (p:Post {id: "bbbbbbbb-bbbb-bbbb-bbbb-bbbbbbbbbbbb"})
CREATE (b)-[:POSTED {created_at: "2024-12-01T00:00:00.000Z"}]->(p);

// Charlie → Enjoying the weather
MATCH (c:Profil {id: "33333333-3333-3333-3333-333333333333"}),
      (p:Post {id: "cccccccc-cccc-cccc-cccc-cccccccccccc"})
CREATE (c)-[:POSTED {created_at: "2024-11-15T00:00:00.000Z"}]->(p);

// Didié → Traveling to Paris
MATCH (d:Profil {id: "44444444-4444-4444-4444-444444444444"}),
      (p:Post {id: "dddddddd-dddd-dddd-dddd-dddddddddddd"})
CREATE (d)-[:POSTED {created_at: "2024-11-20T00:00:00.000Z"}]->(p);

// Relations Comment ////////////////////////////////////////////////////

MATCH
  (h:Post {id: "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"}),
  (l:Post {id: "bbbbbbbb-bbbb-bbbb-bbbb-bbbbbbbbbbbb"}),
  (t:Post {id: "dddddddd-dddd-dddd-dddd-dddddddddddd"}),
  (p:Post {id: "cccccccc-cccc-cccc-cccc-cccccccccccc"}),

  (a:Profil {id: "11111111-1111-1111-1111-111111111111"}),
  (b:Profil {id: "22222222-2222-2222-2222-222222222222"}),
  (c:Profil {id: "33333333-3333-3333-3333-333333333333"}),
  (d:Profil {id: "55555555-5555-5555-5555-555555555555"}),
  (e:Profil {id: "44444444-4444-4444-4444-444444444444"})

CREATE
  // Hello world!
  (b)-[:COMMENT {id:"c001", text:"Salut",      created_at:"2024-11-02T00:00:00.000Z", updated_at:"2024-11-02T00:00:00.000Z"}]->(h),
  (c)-[:COMMENT {id:"c002", text:"Bienvenue", created_at:"2024-11-03T00:00:00.000Z", updated_at:"2024-11-03T00:00:00.000Z"}]->(h),
  (d)-[:COMMENT {id:"c003", text:"Cool",      created_at:"2024-11-04T00:00:00.000Z", updated_at:"2024-11-04T00:00:00.000Z"}]->(h),
  (e)-[:COMMENT {id:"c004", text:"Top",       created_at:"2024-11-05T00:00:00.000Z", updated_at:"2024-11-05T00:00:00.000Z"}]->(h),
  (b)-[:COMMENT {id:"c005", text:"Yes",       created_at:"2024-11-06T00:00:00.000Z", updated_at:"2024-11-06T00:00:00.000Z"}]->(h),
  (b)-[:COMMENT {id:"c006", text:"Nice",      created_at:"2024-11-07T00:00:00.000Z", updated_at:"2024-11-07T00:00:00.000Z"}]->(h),
  (e)-[:COMMENT {id:"c007", text:"Super",     created_at:"2024-11-08T00:00:00.000Z", updated_at:"2024-11-08T00:00:00.000Z"}]->(h),
  (a)-[:COMMENT {id:"c008", text:"Parfait",   created_at:"2024-11-09T00:00:00.000Z", updated_at:"2024-11-09T00:00:00.000Z"}]->(h),

  // Learning Cypher
  (a)-[:COMMENT {id:"c009", text:"Bien",      created_at:"2024-12-02T00:00:00.000Z", updated_at:"2024-12-02T00:00:00.000Z"}]->(l),
  (c)-[:COMMENT {id:"c010", text:"Ok",        created_at:"2024-12-03T00:00:00.000Z", updated_at:"2024-12-03T00:00:00.000Z"}]->(l),
  (d)-[:COMMENT {id:"c011", text:"Cool",      created_at:"2024-12-04T00:00:00.000Z", updated_at:"2024-12-04T00:00:00.000Z"}]->(l),
  (e)-[:COMMENT {id:"c012", text:"Yes",       created_at:"2024-12-05T00:00:00.000Z", updated_at:"2024-12-05T00:00:00.000Z"}]->(l),
  (c)-[:COMMENT {id:"c013", text:"Top",       created_at:"2024-12-06T00:00:00.000Z", updated_at:"2024-12-06T00:00:00.000Z"}]->(l),
  (d)-[:COMMENT {id:"c014", text:"Nice",      created_at:"2024-12-07T00:00:00.000Z", updated_at:"2024-12-07T00:00:00.000Z"}]->(l),
  (e)-[:COMMENT {id:"c015", text:"Super",     created_at:"2024-12-08T00:00:00.000Z", updated_at:"2024-12-08T00:00:00.000Z"}]->(l),

  // Enjoying the weather
  (a)-[:COMMENT {id:"c016", text:"Soleil",    created_at:"2024-11-16T00:00:00.000Z", updated_at:"2024-11-16T00:00:00.000Z"}]->(p),
  (a)-[:COMMENT {id:"c017", text:"Chaud",     created_at:"2024-11-17T00:00:00.000Z", updated_at:"2024-11-17T00:00:00.000Z"}]->(p),
  (b)-[:COMMENT {id:"c018", text:"Cool",      created_at:"2024-11-18T00:00:00.000Z", updated_at:"2024-11-18T00:00:00.000Z"}]->(p),
  (e)-[:COMMENT {id:"c019", text:"Yes",       created_at:"2024-11-19T00:00:00.000Z", updated_at:"2024-11-19T00:00:00.000Z"}]->(p),
  (e)-[:COMMENT {id:"c020", text:"Top",       created_at:"2024-11-20T00:00:00.000Z", updated_at:"2024-11-20T00:00:00.000Z"}]->(p),
  (c)-[:COMMENT {id:"c021", text:"Nice",      created_at:"2024-11-21T00:00:00.000Z", updated_at:"2024-11-21T00:00:00.000Z"}]->(p),
  (c)-[:COMMENT {id:"c022", text:"Super",     created_at:"2024-11-22T00:00:00.000Z", updated_at:"2024-11-22T00:00:00.000Z"}]->(p),

  // Traveling to Paris
  (a)-[:COMMENT {id:"c023", text:"Paris",     created_at:"2024-11-23T00:00:00.000Z", updated_at:"2024-11-23T00:00:00.000Z"}]->(t),
  (c)-[:COMMENT {id:"c024", text:"Tour Eiffel", created_at:"2024-11-24T00:00:00.000Z", updated_at:"2024-11-24T00:00:00.000Z"}]->(t),
  (d)-[:COMMENT {id:"c025", text:"Louvre",    created_at:"2024-11-25T00:00:00.000Z", updated_at:"2024-11-25T00:00:00.000Z"}]->(t),
  (e)-[:COMMENT {id:"c026", text:"Metro",     created_at:"2024-11-26T00:00:00.000Z", updated_at:"2024-11-26T00:00:00.000Z"}]->(t),
  (c)-[:COMMENT {id:"c027", text:"Croissant", created_at:"2024-11-27T00:00:00.000Z", updated_at:"2024-11-27T00:00:00.000Z"}]->(t),
  (d)-[:COMMENT {id:"c028", text:"Seine",     created_at:"2024-11-28T00:00:00.000Z", updated_at:"2024-11-28T00:00:00.000Z"}]->(t),
  (e)-[:COMMENT {id:"c029", text:"Notre Dame", created_at:"2024-11-29T00:00:00.000Z", updated_at:"2024-11-29T00:00:00.000Z"}]->(t),
  (e)-[:COMMENT {id:"c030", text:"Montmartre", created_at:"2024-11-30T00:00:00.000Z", updated_at:"2024-11-30T00:00:00.000Z"}]->(t);
