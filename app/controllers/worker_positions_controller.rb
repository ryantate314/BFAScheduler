class WorkerPositionsController < ApplicationController
  before_action :set_worker_position, only: [:show, :edit, :update, :destroy]

  # GET /worker_positions
  # GET /worker_positions.json
  def index
    @worker_positions = WorkerPosition.all
  end

  # GET /worker_positions/1
  # GET /worker_positions/1.json
  def show
  end

  # GET /worker_positions/new
  def new
    @worker_position = WorkerPosition.new
  end

  # GET /worker_positions/1/edit
  def edit
  end

  # POST /worker_positions
  # POST /worker_positions.json
  def create
    @worker_position = WorkerPosition.new(worker_position_params)

    respond_to do |format|
      if @worker_position.save
        format.html { redirect_to @worker_position, notice: 'Worker position was successfully created.' }
        format.json { render :show, status: :created, location: @worker_position }
      else
        format.html { render :new }
        format.json { render json: @worker_position.errors, status: :unprocessable_entity }
      end
    end
  end

  # PATCH/PUT /worker_positions/1
  # PATCH/PUT /worker_positions/1.json
  def update
    respond_to do |format|
      if @worker_position.update(worker_position_params)
        format.html { redirect_to @worker_position, notice: 'Worker position was successfully updated.' }
        format.json { render :show, status: :ok, location: @worker_position }
      else
        format.html { render :edit }
        format.json { render json: @worker_position.errors, status: :unprocessable_entity }
      end
    end
  end

  # DELETE /worker_positions/1
  # DELETE /worker_positions/1.json
  def destroy
    @worker_position.destroy
    respond_to do |format|
      format.html { redirect_to worker_positions_url, notice: 'Worker position was successfully destroyed.' }
      format.json { head :no_content }
    end
  end

  private
    # Use callbacks to share common setup or constraints between actions.
    def set_worker_position
      @worker_position = WorkerPosition.find(params[:id])
    end

    # Never trust parameters from the scary internet, only allow the white list through.
    def worker_position_params
      params.require(:worker_position).permit(:description, :estimatedHours, :has_one)
    end
end
