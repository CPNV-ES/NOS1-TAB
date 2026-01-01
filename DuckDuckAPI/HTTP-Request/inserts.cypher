// Duck-insert
// Profils

// Alice
CREATE (:Profil {
  id: "11111111-1111-1111-1111-111111111111",
  name: "Alice",
  image_id: 111111,
  hash: "$2y$12$abcdefghijklmnopqrstuv", 
  created_at: "2024-10-01T00:00:00.000Z",
  updated_at: "2024-10-01T00:00:00.000Z"
});

// Bob
CREATE (:Profil {
  id: "22222222-2222-2222-2222-222222222222",
  name: "Bob",
  image_id: 222222,
  hash: "$2y$12$abcdefghijklmnopqrstuv",
  created_at: "2024-10-02T00:00:00.000Z",
  updated_at: "2024-10-02T00:00:00.000Z"
});

// Charlie
CREATE (:Profil {
  id: "33333333-3333-3333-3333-333333333333",
  name: "Charlie",
  image_id: 333333,
  hash: "$2y$12$abcdefghijklmnopqrstuv",
  created_at: "2024-10-03T00:00:00.000Z",
  updated_at: "2024-10-03T00:00:00.000Z"
});

// Didié
CREATE (:Profil {
  id: "44444444-4444-4444-4444-444444444444",
  name: "Didié",
  image_id: 444444,
  hash: "$2y$12$abcdefghijklmnopqrstuv",
  created_at: "2024-10-04T00:00:00.000Z",
  updated_at: "2024-10-04T00:00:00.000Z"
});

// Diana
CREATE (:Profil {
  id: "55555555-5555-5555-5555-555555555555",
  name: "Diana",
  image_id: 555555,
  hash: "$2y$12$abcdefghijklmnopqrstuv",
  created_at: "2024-10-05T00:00:00.000Z",
  updated_at: "2024-10-05T00:00:00.000Z"
});

// Relations FRIEND

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
