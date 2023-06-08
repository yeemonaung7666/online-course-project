$update=DB::raw("UPDATE articles set title="$request['title']",
                                            slug="Helper::slug($request['title'])",
                                            image='$path',
                                            description="$request['description']"
                                            WHERE slug='$slug'")->get();
            return "success";