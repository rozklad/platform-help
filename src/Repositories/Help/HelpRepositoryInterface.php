<?php namespace Sanatorium\Help\Repositories\Help;

interface HelpRepositoryInterface {

	/**
	 * Returns a dataset compatible with data grid.
	 *
	 * @return \Sanatorium\Help\Models\Help
	 */
	public function grid();

	/**
	 * Returns all the help entries.
	 *
	 * @return \Sanatorium\Help\Models\Help
	 */
	public function findAll();

	/**
	 * Returns a help entry by its primary key.
	 *
	 * @param  int  $id
	 * @return \Sanatorium\Help\Models\Help
	 */
	public function find($id);

	/**
	 * Determines if the given help is valid for creation.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Support\MessageBag
	 */
	public function validForCreation(array $data);

	/**
	 * Determines if the given help is valid for update.
	 *
	 * @param  int  $id
	 * @param  array  $data
	 * @return \Illuminate\Support\MessageBag
	 */
	public function validForUpdate($id, array $data);

	/**
	 * Creates or updates the given help.
	 *
	 * @param  int  $id
	 * @param  array  $input
	 * @return bool|array
	 */
	public function store($id, array $input);

	/**
	 * Creates a help entry with the given data.
	 *
	 * @param  array  $data
	 * @return \Sanatorium\Help\Models\Help
	 */
	public function create(array $data);

	/**
	 * Updates the help entry with the given data.
	 *
	 * @param  int  $id
	 * @param  array  $data
	 * @return \Sanatorium\Help\Models\Help
	 */
	public function update($id, array $data);

	/**
	 * Deletes the help entry.
	 *
	 * @param  int  $id
	 * @return bool
	 */
	public function delete($id);

}
