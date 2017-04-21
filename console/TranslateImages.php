<?php
/**
 * Created by PhpStorm.
 * User: saschaaeppli
 * Date: 21.04.17
 * Time: 13:57
 */

namespace Ffte\Movies\Console;
use Ffte\Movies\Models\Movie;
use Illuminate\Console\Command;

class TranslateImages extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'movies:trans';

    /**
     * Execute the console command.
     * @return void
     */
    public function fire()
    {
        $data = json_decode(file_get_contents('http://filmefuerdieerde.ch/api/movies'), true);

        foreach( $data as $m ) {
            $id = $m['id'];
            $movie = Movie::find($id);
            if($movie) {

                foreach($m['images'] as $img) {
                    $image = $movie->images()->where(['file_name' => $img['name']])->first();
                    if($image) {
                        if(array_key_exists('description_en', $img)) {
                            $image->lang('en')->description = $img['description_en'];
                            $image->save();
                        }
                    }
                }
            } else {
                $this->output->writeln("$id not found");
            }
        }

        $this->output->writeln('done');
    }

}