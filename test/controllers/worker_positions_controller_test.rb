require 'test_helper'

class WorkerPositionsControllerTest < ActionController::TestCase
  setup do
    @worker_position = worker_positions(:one)
  end

  test "should get index" do
    get :index
    assert_response :success
    assert_not_nil assigns(:worker_positions)
  end

  test "should get new" do
    get :new
    assert_response :success
  end

  test "should create worker_position" do
    assert_difference('WorkerPosition.count') do
      post :create, worker_position: { description: @worker_position.description, estimatedHours: @worker_position.estimatedHours, has_one: @worker_position.has_one }
    end

    assert_redirected_to worker_position_path(assigns(:worker_position))
  end

  test "should show worker_position" do
    get :show, id: @worker_position
    assert_response :success
  end

  test "should get edit" do
    get :edit, id: @worker_position
    assert_response :success
  end

  test "should update worker_position" do
    patch :update, id: @worker_position, worker_position: { description: @worker_position.description, estimatedHours: @worker_position.estimatedHours, has_one: @worker_position.has_one }
    assert_redirected_to worker_position_path(assigns(:worker_position))
  end

  test "should destroy worker_position" do
    assert_difference('WorkerPosition.count', -1) do
      delete :destroy, id: @worker_position
    end

    assert_redirected_to worker_positions_path
  end
end
