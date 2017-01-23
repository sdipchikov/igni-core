<?php


namespace Despark\Cms\Http\Controllers;


use Despark\Cms\Http\Requests\AdminFormRequest;

class ResourceController extends AdminController
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->viewData['record'] = $this->model;

        $this->viewData['actionVerb'] = 'Create';
        $this->viewData['formMethod'] = 'POST';
        $this->viewData['formAction'] = ':resource.store';

        return view($this->defaultFormView, $this->viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param :request_name $request
     *
     * @return Response
     */
    public function store(AdminFormRequest $request)
    {
        $input = $request->all();

        $record = $this->model->create($input);

        $this->notify([
            'type' => 'success',
            'title' => 'Successful create!',
            'description' => ':model_name is created successfully!',
        ]);

        return redirect(route(':resource.edit', ['id' => $record->id]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $record = $this->model->findOrFail($id);

        $this->viewData['record'] = $record;

        $this->viewData['formMethod'] = 'PUT';
        $this->viewData['formAction'] = ':resource.update';

        return view($this->defaultFormView, $this->viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param :request_name $request
     * @param int $id
     *
     * @return Response
     */
    public function update(AdminFormRequest $request, $id)
    {
        $input = $request->all();

        $record = $this->model->findOrFail($id);

        $record->update($input);

        $this->notify([
            'type' => 'success',
            'title' => 'Successful update!',
            'description' => ':model_name is updated successfully.',
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $this->model->findOrFail($id)->delete();

        $this->notify([
            'type' => 'danger',
            'title' => 'Successful delete!',
            'description' => ':model_name is deleted successfully.',
        ]);

        return redirect()->back();
    }

}